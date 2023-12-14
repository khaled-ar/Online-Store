<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function __construct() {
        $this->middleware( 'auth:sanctum' )->except( 'index', 'show' );
    }

    public function index( Request $request ) {
        $products = Product::apiFilter( $request->query() )
        ->with( 'category:id,name', 'store:id,name', 'tags:id,name' )
        ->paginate();
        return ProductResource::collection( $products );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255', 'unique:products,name' ],
            'description' => [ 'nullable', 'string' ],
            'price' => [ 'required', 'numeric', 'min:0' ],
            'compare_price' => [ 'nullable', 'numeric', 'min:0' ],
            'category_id' => [ 'required', 'int' ],
            'store_id' => [ 'required', 'int' ],
        ] );

        $user = $request->user();
        if ( !$user->tokenCan( 'products.create' ) ) {
            return response( 'Not Allowed', 403 );
        }
        return Product::create( $request->all() );
    }

    /**
    * Display the specified resource.
    */

    public function show( Product $product ) {
        return new ProductResource( $product );
        // return $product
        // ->load( 'category:id,name', 'store:id,name', 'tags' );
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, Product $product ) {
        $request->validate( [
            'name' => [ 'sometimes', 'required', 'string', 'max:255', "unique:products,name,{$product->id},id" ],
            'description' => [ 'sometimes', 'nullable', 'string' ],
            'price' => [ 'sometimes', 'required', 'numeric', 'min:0' ],
            'compare_price' => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
            'category_id' => [ 'sometimes', 'required', 'int' ],
            'store_id' => [ 'sometimes', 'required', 'int' ],
        ] );

        $product->update( $request->all() );
        $user = $request->user();
        if ( !$user->tokenCan( 'products.update' ) ) {
            return response( [ 'Not Allowed' ], 403 );
        }

        return response()->json( $product );
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( $id ) {
        $user = Auth::guard( 'sanctum' )->user();
        if ( !$user->tokenCan( 'products.update' ) ) {
            return response( 'Not Allowed', 403 );
        }
        Product::destroy( $id );
        return [
            'message' => 'Product Deleted Successfully.',
        ];
    }
}
