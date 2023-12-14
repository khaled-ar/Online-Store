<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ProductsController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        $request = request();
        $products = Product::with( [ 'category', 'store' ] )
        ->Filter( $request->all() )
        ->latest()
        ->paginate();
        return view( 'dashboard.products.index', compact( 'products' ) );
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        $categories = Category::all();
        $stores = Store::all();
        $product = new Product();
        $tags = '';
        return view( 'dashboard.products.create', compact( 'categories', 'stores', 'product', 'tags' ) );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255', 'unique:products,name' ],
            'description' => [ 'nullable', 'string' ],
            'price' => [ 'required', 'string' ],
            'compare_price' => [ 'nullable', 'string' ],
            'category_id' => [ 'required', 'int' ],
            'store_id' => [ 'required', 'int' ],
            'tags' => [ 'nullable', 'string' ],
            'status' => [ 'nullable', 'string', 'in:active,draft,archived' ],
            'img' => [ 'image', 'max:1125899906842624', 'dimensions:max_width=5000,max_height=5000' ],
        ] );

        // Request Merge
        $request->merge( [
            'slug' => Str::slug( $request->post( 'name' ) )
        ] );

        // img
        $data = $request->except( [ 'img', 'tags' ] );
        $img = $this->uploadImage( $request );
        if ( $img ) {
            $data[ 'img' ] = $img;
        }

        $product = Product::create( $data );

        // tags
        $tags = json_decode( $request->post( 'tags' ) );
        $tag_ids = [];
        $all_tags = Tag::all();

        foreach ( $tags as $item ) {
            $slug = Str::slug( $item->value );
            $tag = $all_tags->where( 'slug', $slug )->first();
            if ( !$tag ) {
                $tag = Tag::create( [ 'name' => strtolower( trim( $item->value ) ), 'slug' => $slug ] );
            }
            $tag_ids[] = $tag->id;
        }
        $product->tags()->sync( $tag_ids );

        return Redirect::route( 'dashboard.products.index' )
        ->with( 'success', 'Product Created Successfully.' );
    }

    /**
    * Display the specified resource.
    */

    public function show( string $id ) {

    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( string $id ) {
        $product = Product::findOrfail( $id );
        $tags = implode( ',', $product->tags()->pluck( 'name' )->toArray() );
        return view( 'dashboard.products.edit', compact( 'product', 'tags' ) );
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, string $id ) {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255', "unique:products,name,$id", !'in_array:allah,god,bad' ],
            'description' => [ 'nullable', 'string' ],
            'price' => [ 'required', 'string' ],
            'compare_price' => [ 'nullable', 'string' ],
            'category_id' => [ 'required', 'int' ],
            'store_id' => [ 'required', 'int' ],
            'tags' => [ 'nullable', 'string' ],
            'status' => [ 'nullable', 'string', 'in:active,draft,archived' ],
            'img' => [ 'image', 'max:1125899906842624', 'dimensions:max_width=5000,max_height=5000' ],
        ] );

        $product = Product::find( $id );
        // img
        $old_img = $product->img;
        $data = $request->except( [ 'img', 'tags' ] );
        $new_img = $this->uploadImage( $request );
        if ( $new_img ) {
            $data[ 'img' ] = $new_img;
        }

        $product->update( $data );

        // tags
        $tags = json_decode( $request->post( 'tags' ) );
        $tag_ids = [];
        $all_tags = Tag::all();

        foreach ( $tags as $item ) {
            $slug = Str::slug( $item->value );
            $tag = $all_tags->where( 'slug', $slug )->first();
            if ( !$tag ) {
                $tag = Tag::create( [ 'name' => strtolower( trim( $item->value ) ), 'slug' => $slug ] );
            }
            $tag_ids[] = $tag->id;
        }
        $product->tags()->sync( $tag_ids );

        // delete old image
        if ( $old_img && $new_img ) {
            Storage::disk( 'public' )->delete( $old_img );
        }
        return Redirect::route( 'dashboard.products.index' )
        ->with( 'success', 'Product Updated Successfully.' );

    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( Product $product ) {
        $product->delete();
        return Redirect::route( 'dashboard.products.index' )
        ->with( 'success', 'Product Moved To Trash Page.' );
    }

    public function trash() {
        $request = request();
        $products = Product::onlyTrashed()
        ->Filter( $request->all() )
        ->paginate();
        return view( 'dashboard.products.trash', compact( 'products' ) );
    }

    public function restore( Request $request, $id ) {
        $product = Product::onlyTrashed()->findOrFail( $id );
        $product->restore();

        return Redirect::route( 'dashboard.products.index' )
        ->with( 'success', 'Product Restored Successfully.' );
    }

    public function forceDelete( $id ) {
        $product = Product::onlyTrashed()->findOrFail( $id );
        $product->forceDelete();
        if ( $product->img ) {
            Storage::disk( 'public' )->delete( $product->img );
        }

        return Redirect::route( 'dashboard.products.index' )
        ->with( 'success', 'Product Deleted Successfully.' );
    }

    protected function uploadImage( Request $request ) {

        if ( !$request->hasFile( 'img' ) ) {
            return;
        }
        $img = $request->file( 'img' );
        // file : return UploadedFile object
        // check if the iploaded file is image
        if ( substr( $img->getMimeType(), 0, 5 ) == 'image' ) {
            return $img->store( 'uploads', 'public' );
        } else {
            Redirect::route( 'dashboard.products.index' );
        }
    }
}
