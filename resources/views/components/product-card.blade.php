<!-- Start Single Product -->
<div class="single-product">
    <div class="product-image">
        <img src="{{ $product->img_url }}" alt="#" style="height: 200px;">
        @if ($product->compare_price)
            <span class="sale-tag" style="top: 30px">{{ $product->sale_percent }}%</span>
        @endif
        @if (strtotime('now') <= strtotime($product->created_at . ' +1 Month'))
            <span class="new-tag" style="left: 0">{{ __('New') }}</span>
        @endif
        <div class="button">
            <a href="{{ route('products.show', $product->slug) }}" class="btn">
                <i class="lni lni-cart"></i> {{ __('Add To Cart') }}
            </a>
        </div>
    </div>
    <div class="product-info">
        <span class="category">
            @if (Session::get('locale') == 'ar')
                {{ $product->category->ar_name ? $product->category->ar_name : $product->category->name }}
            @elseif (Session::get('locale') == 'fr')
                {{ $product->category->fr_name ? $product->category->fr_name : $product->category->name }}
            @else
                {{ $product->category->name }}
            @endif
        </span>
        <h4 class="title">
            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
        </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star"></i></li>
            <li><span>4.0 {{ __('Review(s)') }}</span></li>
        </ul>
        <div class="price">
            @if ($product->compare_price)
                <span> {{ Currency::format($product->compare_price) }} </span>
                <span class="discount-price"> {{ Currency::format($product->price) }}</span>
            @else
                <span>{{ Currency::format($product->price) }}</span>
            @endif
        </div>
    </div>
</div>
<!-- End Single Product -->
