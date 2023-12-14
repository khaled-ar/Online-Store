<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WishlistController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {

        $products_id = explode( ',', Cookie::get( 'wishlist' ) );
        $products = Product::whereIn( 'id', $products_id )->get();
        return view( 'front.wishlist', compact( 'products' ) );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        $request->validate( [
            'product_id' => [ 'required', 'int', 'exists:products,id' ],
        ] );

        $product_id = $request->post( 'product_id' );
        $items = explode( ',', Cookie::get( 'wishlist' ) );
        if ( in_array( $product_id, $items ) ) {
            return redirect()->back();
        }

        $items[] = $product_id;

        Cookie::queue( 'wishlist',
            implode( ',', $items ),
            count( $items ) == 2 ?
            time() + 60*24*60*60 :
            cookie( 'wishlist' )->getMaxAge() -  time()
        );
        return redirect()->back();
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( string $id ) {
        $items = explode( ',', Cookie::get( 'wishlist' ) );
        unset( $items[ array_search( $id, $items ) ] );
        Cookie::queue( 'wishlist', implode( ',', $items ) );
        return redirect()->back();
    }
}
