<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Models\Feature;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // <-- Correct import
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
        
        Log::info("🔥 WEBHOOK RECEIVED");

        $endpoint_secret = env('STRIPE_WEBHOOK_KEY');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );

        } catch (\Throwable $e) {
            // Log::error("❌ Webhook signature verification failed: " . $e->getMessage());
            // return response('', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
    Log::info("💸 Checkout completed — updating credits");
    $session = $event->data->object;

    $transaction = Transaction::where('session_id', $session->id)->first();

    if ($transaction && $transaction->status === 'pending') {

        Log::info("SESSION ID: " . $session->id);
        Log::info("USER BEFORE: " . $transaction->user->available_credits);

        $transaction->status = 'paid';
        $transaction->save();

        $transaction->user->available_credits += $transaction->credits;
        $transaction->user->save();

        Log::info("USER AFTER: " . $transaction->user->fresh()->available_credits);
        Log::info("🎉 Credits added successfully for user: " . $transaction->user_id);
    } else {
        Log::warning("⚠️ No matching pending transaction found OR already paid.");
    }
    break;


            default:
                Log::info("ℹ️ Ignored event type: " . $event->type);
        }

        return response('ok', 200);
    }
}
