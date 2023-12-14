<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhooksController extends Controller {
    public function handle() {

        $payload = @file_get_contents( 'php://input' );
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode( $payload, true )
            );
        } catch( \UnexpectedValueException $e ) {
            // Invalid payload
            http_response_code( 400 );
            exit();
        } catch( \Stripe\Exception\SignatureVerificationException $e ) {
            // Invalid signature
            http_response_code( 400 );
            exit();
        }

        // Handle the event
        switch ( $event->type ) {
            case 'payment_intent.succeeded':
            $paymentIntent = $event->data->object;
            Log::debug( 'Payment Succeeded', [ $paymentIntent->id ] );
            default:
            echo 'Received unknown event type ' . $event->type;
        }
    }
}
