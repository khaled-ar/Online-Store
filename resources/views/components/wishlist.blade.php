<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-heart"></i>
        <span class="total-items">{{ count($products) }}</span>
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{ count($products) . ' ' . __('Items') }} </span>
            <a href="{{ route('wishlist.index') }}">{{ __('View All') }}</a>
        </div>
        <ul class="shopping-list">
            @foreach ($products as $product)
                <li>
                    <form action="{{ route('wishlist.destroy', $product->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="remove">
                            <i class="lni lni-close"></i>
                        </button>
                    </form>

                    <div class="cart-img-head">
                        <a class="cart-img" href="{{ route('products.show', $product->slug) }}"><img
                                src="{{ $product->img_url }}" alt="#" /></a>
                    </div>
                    <div class="content">
                        <h4>
                            <a href="{{ route('products.show', $product->slug) }}"><u>{{ $product->name }}</u></a>
                        </h4>
                        <span class="amount">
                            @if ($product->compare_price)
                                {{ Currency::format($product->compare_price) }}
                            @else
                                {{ Currency::format($product->price) }}
                            @endif
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!--/ End Shopping Item -->
</div>
