<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart)
    {
        return view('front.carts.index', compact('cart'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $product = Product::find($request->post('product_id'));
        $cart->add($product, $request->post('quantity'));
        return Redirect::route('cart.index')
                ->with('success', 'Product Added To Cart Successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'int', 'min:1'],
        ]);

        if($this->update($id, $request->post('quantity'))) {
            return Redirect::route('cart.index')
                ->with('success', 'Product Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart, int $id)
    {
        if($cart->delete($id)) {
            return Redirect::route('cart.index')
                ->with('success', 'Product Deleted Successfully.');
        }
    }
}
