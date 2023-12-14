<?php

namespace App\View\Components;

use App\Helpers\Currency;
use App\Repositories\Cart\CartRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartMenu extends Component {
    public $items;
    public $total = 0;
    public $count = 0;
    /**
    * Create a new component instance.
    */

    public function __construct( CartRepository $cart ) {

        $this->items = $cart->get();
        $this->count = $this->items->count();
        foreach ( $this->items as $item ) {
            $compare_price = $item->product->compare_price;
            if ( $compare_price ) {
                $this->total += $item->quantity * $compare_price;
            } else {
                $this->total += $item->quantity * $item->product->price;
            }
        }
        $this->total = Currency::format( $this->total );
    }

    /**
    * Get the view / contents that represent the component.
    */

    public function render(): View|Closure|string {
        return view( 'components.cart-menu', [
            'items' => $this->items,
            'total' => $this->total,
            'count' => $this->count,
        ] );
    }
}
