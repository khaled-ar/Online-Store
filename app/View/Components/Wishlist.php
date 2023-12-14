<?php

namespace App\View\Components;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\Component;

class Wishlist extends Component {
    /**
    * Create a new component instance.
    */

    public function __construct() {
        //
    }

    /**
    * Get the view / contents that represent the component.
    */

    public function render(): View|Closure|string {

        $items_id = explode( ',', Cookie::get( 'wishlist' ) );
        $products = Product::whereIn( 'id', $items_id )->take( 10 )->get();

        return view( 'components.wishlist', [
            'products' => $products,
        ] );
    }
}
