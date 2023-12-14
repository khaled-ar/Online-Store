<div class="cart-items" style="margin-left: 10px">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items">{{ $count }}</span>
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{ $count . ' ' . __('Items') }} </span>
            <a href="{{ route('cart.index') }}"> {{ __('View Cart') }}</a>
        </div>
        <ul class="shopping-list">
            @foreach ($items as $item)
                <li>
                    <a href="{{ route('cart.destroy', $item->product->id) }}" class="remove" title="Remove this item"><i
                            class="lni lni-close"></i></a>
                    <div class="cart-img-head">
                        <a class="cart-img" href="{{ route('products.show', $item->product->slug) }}"><img
                                src="{{ $item->product->img_url }}" alt="#" /></a>
                    </div>
                    <div class="content">
                        <h4>
                            <a
                                href="{{ route('products.show', $item->product->slug) }}"><u>{{ $item->product->name }}</u></a>
                        </h4>
                        <p class="quantity">
                            {{ $item->quantity }}x - <span class="amount">
                                @if ($item->product->compare_price)
                                    {{ Currency::format($item->quantity * $item->product->compare_price) }}
                                @else
                                    {{ Currency::format($item->quantity * $item->product->price) }}
                                @endif
                            </span>
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="bottom">
            <div class="total">
                <span>{{ __('Total') }}</span>
                <span class="total-amount">{{ $total }}</span>
            </div>
            <div class="button">
                <a href="{{ route('checkout') }}" class="btn animate">{{ __('Checkout') }}</a>
            </div>
        </div>
    </div>
    <!--/ End Shopping Item -->
</div>
