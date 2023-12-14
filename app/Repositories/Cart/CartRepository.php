<?php

namespace App\Repositories\Cart;

use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepository {

    // get all products from the cart
    public function get() : Collection;

    // add a new product into the cart (return void)
    public function add(Product $product, int $quantity = 1) : void;

    // update a quantity of the product (return bool)
    public function update($id, int $quantity) : bool;

    // delete the product from the cart (return bool)
    public function delete(int $id) : bool;

    // empty the cart (return bool)
    public function empty() : bool;

}
