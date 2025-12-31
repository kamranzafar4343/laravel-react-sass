<?php

namespace App\Http\Controllers;
use App\Http\Resources\FeatureResource;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Models\Feature;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    //display credit page
    // Fetch all packages (credit plans) & Fetch active features
    public function index()
    {
        $packages = Package::all();
        $features = Feature::where('active', true)->get();
        return inertia("Credit/Index", [
            'packages' => PackageResource::collection($packages),
            'features' => FeatureResource::collection($features),
            'success' => session('success') ?? false,
            'error' => session('error') ?? false
        ]);

    }

    // Start Purchase (Stripe Checkout)
    // Create Stripe checkout session with:
    // package name, price, credits
    // success and cancel URLs
    // metadata (user + package info)
    // Save a pending transaction in database
    // Redirect user to Stripe payment page
    public function buyCredits(Package $package)
{
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

    $checkout_session = $stripe->checkout->sessions->create([
        'line_items' => [[            // <--- FIXED (double array)
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $package->name . ' - ' . $package->credits . ' credits',
                ],
                'unit_amount' => (int)($package->price * 100),  // <--- must be integer
            ],
            'quantity' => 1,
        ]],
        
        'mode' => 'payment',
        'success_url' => route('credit.success', [], true),
        'cancel_url' => route('credit.cancel', [], true),
        'metadata' => [
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'credits' => $package->credits,
        ],
    ]);

    Transaction::create([
        'status' => 'pending',
        'price' => $package->price,
        'credits' => $package->credits,
        'session_id' => $checkout_session->id,
        'user_id' => Auth::id(),
        'packages_id' => $package->id,
    ]);

    return redirect($checkout_session->url);
}


    public function success(){

        return to_route('credit.index')
        ->with('success', 'You successfully bought new credits');
    }

    public function cancel(){
        return to_route('credit.index')
        ->with('error', 'There was an error. Please try again');
    }


    // 🔴 Webhook: Final Credit Confirmation
    // Stripe calls webhook after real payment
    // Verify Stripe signature (auth check)
    // Find matching pending transaction
    // Mark it as paid
    // Add credits to the user account
    // Save updated credits
    public function webhook(){

        $endpoint_secret = env('STRIPE_WEBHOOK_KEY');

        $payload = @file_get_contents('php://input');

        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

        try{
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        }
        catch (\UnexpectedValueException $e){
            return response('', 400);

        }
        catch(\Stripe\Exception\SignatureVerificationException $e){
            return response('', 400);
        }

        switch($event->type){
            case 'checkout.session.completed';
            $session = $event->data->object;

            $transaction = Transaction::where('session_id',
            $session->id)->first();
            if($transaction && $transaction->status === 'pending'){
                $transaction->status = 'paid';
                 $transaction->user->available_credits +=
                 $transaction->credits;
                 $transaction->user->save();
            }

            default:
            echo 'Received unknow event type ' . $event->type;
        }
        return response('');
    }
}


// 🎯 Overall Flow in 6 Steps

// User selects credit package

// Controller sends them to Stripe checkout

// User pays → Stripe returns to success page

// Stripe webhook confirms payment (backend call)

// Transaction updated to "paid"

// Credits added to user account