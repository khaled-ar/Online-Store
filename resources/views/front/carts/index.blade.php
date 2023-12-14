<x-front-layout title="Cart">
    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Shopping Cart</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('products.index') }}">Shop</a></li>
                            <li>omnis animi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <x-alert type="success" style="margin-left: 0px" />

    <section class="pt-5 pb-5">
        @php
            $items = $cart->get();
            $total = 0;
            $count = count($items);
        @endphp
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center">
                        @if ($count)
                            Shopping Cart
                        @else
                            {{ 'No Items In Your Cart' }}
                        @endif
                    </h3>
                    <p class="mb-5 text-center">
                        <i class="text-info font-weight-bold">{{ $count }}</i> items in your cart
                    </p>
                    <table id="shoppingCart" class="table table-condensed table-responsive">
                        <thead>
                            <tr>
                                <th style="width:60%">Product</th>
                                <th style="width:12%">Price</th>
                                <th style="width:10%">Quantity</th>
                                <th style="width:5%"></th>
                                <th style="width:10%">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-md-3 text-left">
                                                <img src="{{ $item->product->img_url }}" alt=""
                                                    class="img-fluid d-none d-md-block rounded mb-2 shadow"
                                                    style="width: 250px; height: 150px">
                                            </div>
                                            <div class="col-md-9 text-left mt-sm-2">
                                                <h4 class="product-name mb-3"><a
                                                        href="{{ route('products.show', $item->product->slug) }}">
                                                        <u>{{ $item->product->name }}</u></a></h4>
                                                <h6>{{ $item->product->description }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    @if ($item->product->compare_price)
                                        @php
                                            $total += $item->quantity * $item->product->compare_price;
                                        @endphp
                                        <td data-th="Price">
                                            {{ Currency::format($item->quantity * $item->product->compare_price) }}
                                        @else
                                            @php
                                                $total += $item->quantity * $item->product->price;
                                            @endphp
                                        <td data-th="Price">
                                            {{ Currency::format($item->quantity * $item->product->price) }}
                                        </td>
                                    @endif
                                    <td data-th="Quantity">
                                        <span>{{ $item->quantity }}</span>
                                    </td>
                                    <td></td>
                                    <td class="actions" data-th="">
                                        <div class="col-lg-1 col-md-2 col-12">
                                            <form action="{{ route('cart.destroy', $item->product->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <div>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        style="font-size: 10px">
                                                        <i class="lni lni-close"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-right text-right">
                        <h5>Subtotal:</h5>
                        <h3>{{ Currency::format($total) }}</h3>
                    </div>
                </div>
            </div>
            <div class="row mt-4 d-flex align-items-center">
                <div class="col-sm-6 order-md-2 text-right">
                    <a href="{{ route('checkout') }}" class="btn btn-primary mb-4 pl-5 pr-5">Checkout</a>
                </div>
                <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                    <a href="{{ route('home') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                        </svg>
                        &nbsp;Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>

    @push('js-files')
        <script>
            const csrf_token = "{{ csrf_token() }}";
        </script>
    @endpush
</x-front-layout>
