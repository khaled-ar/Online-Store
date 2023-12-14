<x-front-layout title="Wishlist">
    @push('css-files')
        <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    @endpush
    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">wishlist</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('products.index') }}">Shop</a></li>
                            <li>wishlist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <table class="table table-hover" style="margin-left: 100px; margin-bottom: 80px;"
        class="table table-condensed table-responsive">
        <thead>
            <tr>
                <th style="width:20%" class="plantmore-product-thumbnail">Image</th>
                <th class="cart-product-name">Product</th>
                <th class="plantmore-product-price">Price</th>
                <th class="plantmore-product-add-cart">Add to cart</th>
                <th class="plantmore-product-remove">Remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="plantmore-product-thumbnail"><a class="cart-img"
                            href="{{ route('products.show', $product->slug) }}"><img src="{{ $product->img_url }}"
                                alt="#" style="height: 100px; width:130px" /></a></td>
                    <td class="plantmore-product-name"><a
                            href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></td>
                    <td class="plantmore-product-price"><span
                            class="amount">{{ Currency::format($product->compare_price ?? $product->price) }}</span>
                    </td>
                    <td class="plantmore-product-add-cart"><a href="{{ route('products.show', $product->slug) }}">add to
                            cart</a></td>
                    <td class="plantmore-product-remove">
                        <form action="{{ route('wishlist.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <div>
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="font-size: 10px">
                                    <i class="lni lni-close"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-front-layout>
