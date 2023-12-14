<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller {
    public function create( CartRepository $cart ) {
        if ( $cart->get()->count() == 0 ) {
            throw new InvalidOrderException( 'Cart Is Empty.' );
        }
        return view( 'front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames( 'en' ),
        ] );
    }

    public function store( Request $request, CartRepository $cart ) {
        $request->validate( [
            // billing info
            'addresses.billing.fname' => [ 'required', 'string', 'max:255' ],
            'addresses.billing.lname' => [ 'required', 'string', 'max:255' ],
            // shipping info
            'addresses.shipping.fname' => [ 'required', 'string', 'max:255' ],
            'addresses.shipping.lname' => [ 'required', 'string', 'max:255' ],
        ] );

        $items = $cart->get()->groupBy( 'product.store_id' )->all();

        DB::beginTransaction();
        try {
            foreach ( $items as $store_id => $cart_items ) {
                // create the order
                $order = Order::create( [
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' =>'cod',

                ] );

                // create the items
                foreach ( $cart_items as $item ) {
                    OrderItems::create( [
                        'order_id' => $order->id,
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->compare_price ?? $item->product->price,
                        'quantity' => $item->quantity,
                        'options' => $item->options,
                    ] );
                }

                // create the addresses
                foreach ( $request->post( 'addresses' ) as $type => $address ) {
                    $address[ 'type' ] = $type;
                    $order->addresses()->create( $address );
                }
            }

            DB::commit();
            event( new OrderCreated( $order, $cart ) );
        } catch( InvalidOrderException $e ) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route( 'orders.payments.create', $order );
    }
}
