<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\StripeClient;
use Symfony\Component\Intl\Countries;

class PaymentsController extends Controller {
    public function create( Order $order ) {
        $countries = Countries::getNames( 'en' );
        return view( 'front.payments.create', compact( 'order', 'countries' ) );
    }

    public function createStripePaymentIntet( Order $order ) {

        $amount = $order->items->sum(function($item) {
            return $item->quantity * ($item->compare_price ?? $item->price);
        });

        $stripe = new StripeClient( config( 'services.stripe.secret_key' ) );

        $paymentIntent = $stripe->paymentIntents->create( [
            'amount' => $amount,
            'currency' => Session::get('currency_code'),
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ] );

        return ['clientSecret' => $paymentIntent->client_secret];
    }

    public function confirm(Request $request, Order $order) {
        $stripe = new StripeClient(config( 'services.stripe.secret_key' ));
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intet'),
            []
        );

        if($paymentIntent->status == 'succeeded') {
            // create payment
            $payment = new Payment();
            $payment->forceFill([
                'order_id' => $order->id,
                'amount' => $paymentIntent->amount,
                'currency' => $paymentIntent->currency,
                'method' => 'stripe',
                'status' => 'completed',
                'transaction_id' => $paymentIntent->id,
                'transaction_data' => json_encode($paymentIntent ),
            ])->save();

            // here maybe create a event

            return redirect()
                ->route('home', ['status' => 'payment-succeeded'])
                ->with('success', 'Payment Succeeded');
        }
    }
}
