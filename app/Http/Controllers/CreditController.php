<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Models\Feature;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display credits page with packages + features.
     */
    public function index()
    {
        
        $packages = Package::all();
        $features = Feature::where('active', true)->get();

        return inertia("Credit/Index", [
            'packages' => PackageResource::collection($packages),
            'features' => FeatureResource::collection($features),
            'success' => session('success') ?? false,
            'error' => session('error') ?? false,
        ]);
    }


    /**
     * Start Stripe checkout session.
     */
    public function buyCredits(Package $package)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $package->name . ' - ' . $package->credits . ' credits',
                    ],
                    'unit_amount' => (int)($package->price * 100),
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
            'status'      => 'pending',
            'price'       => $package->price,
            'credits'     => $package->credits,
            'session_id'  => $checkout_session->id,
            'user_id'     => Auth::id(),
            'packages_id' => $package->id,
        ]);

        return redirect($checkout_session->url);
    }


    /**
     * Success redirect after user pays.
     */
    public function success()
    {
        return to_route('credit.index')
            ->with('success', 'You successfully bought new credits');
    }


    /**
     * Payment canceled by user.
     */
    public function cancel()
    {
        return to_route('credit.index')
            ->with('error', 'There was an error. Please try again');
    }


    /**
     * Stripe Webhook - Confirms payment & Adds credits.
     * MUST be reached via CLI listener.
     */
    public function webhook()
    {

        $endpoint_secret = env('STRIPE_WEBHOOK_KEY');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null;

        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );

        } catch (\UnexpectedValueException $e) {
           //Invalid payload
           return response('', 400);
        }catch (\Stripe\Exception\SignatureVerificationException $e){
            // invalid signature
            return response('', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
   
                $session = $event->data->object;

                Log::info('STRIPE SESSION ID: ' . $session->id);
Log::info('ALL DB SESSION IDS: ' . Transaction::pluck('session_id')->implode(','));


    $transaction = Transaction::where('session_id', $session->id)->first();

    if ($transaction && $transaction->status === 'pending') {

        $transaction->status = 'paid';
        $transaction->save();

        $transaction->user->available_credits += $transaction->credits;
        $transaction->user->save();

       }
            default:
                echo 'Received unknown event' . $event->type;
        }

        return response('ok', 200);
    }
}
