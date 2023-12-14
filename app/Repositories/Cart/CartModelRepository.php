<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartModelRepository implements CartRepository {

    public function get(): Collection
    {
        return Cart::with('product')
            ->get();
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $item = Cart::where('product_id', $product->id)
            ->first();
        if(!$item) {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                ]);
        } else {
            $item->increment('quantity', $quantity);
        }

    }

    public function update($id, int $quantity): bool
    {
        return Cart::where('id', $id)
                ->update([
                    'quantity' => $quantity,
            ])
            ? true : false;
    }

    public function delete(int $id): bool
    {
        return Cart::where('product_id', $id)
            ->delete()
            ? true : false;
    }

    public function empty(): bool
    {
        return Cart::query()->delete()
            ? true : false;
    }
}
