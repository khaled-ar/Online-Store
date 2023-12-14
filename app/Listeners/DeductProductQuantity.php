<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DeductProductQuantity {
    /**
    * Create the event listener.
    */

    public function __construct() {
        //
    }

    /**
    * Handle the event.
    */

    public function handle( OrderCreated $event ): void {
        $order = $event->order;
        foreach ( $order->products as $item ) {
            $item->decrement( 'products.quantity', $item->pivot->quantity );

            // or
            // $cart = $event->cart;
            // Product::where( 'id', $item->product_id )
            // ->update( [
            //     'quantity' => DB::raw( "quantity - {$item->quantity}" ),
            // ] );
        }
    }
}
