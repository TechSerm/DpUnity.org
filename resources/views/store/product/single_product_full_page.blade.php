<div>
    <style>
        .discountLebel {
            position: absolute;
            text-align: center;
            color: #ffffff;
            margin-top: 10px;
            margin-left: -26px;
            background-color: #c0392b;
            width: 82px;
            transform: rotate(310deg);
            font-size: 12px;
            padding: 3px 0px 3px 3px;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .productName {
            color: #000000;

        }

        .productName:hover {
            outline: none;
            text-decoration: none;
        }
    </style>
    @if ($isShowPage)
        <div class="row">
            <div class="col-md-6">
    @endif

    @php
        $hasStock = $product->has_stock;
        $incMarketSalePrice = getProductDiscountIncValue($product->market_sale_price);
    @endphp

    <div class="" style="text-align: center">
        <div class="store-card productt product-div {{ $isShowPage ? 'product-card-height-isShowPage' : 'product-card-height' }}"
            style="{{ !$hasStock ? 'opacity: 0.6' : '' }}">
            @if ($product->price < $product->market_sale_price)
                @if ($product->price == 0)
                    <span class="discountLebel" style="background: #c0392b">
                        <b>ফ্রি</b>
                    </span>
                @else
                    <span class="discountLebel">
                        ৳
                        <b>{{ bnConvert()->number($product->market_sale_price - $product->price + $incMarketSalePrice) }}</b>
                        ছাড়
                    </span>
                @endif

            @endif

            @if (!$isShowPage && $hasStock && !$product->isFree())
                <span href="#" wire:click="increment" class="">
            @endif
            <span class="ct-image-container">
                <img id="productImage" src="{{ asset('assets/img/product_loader.gif') }}"
                    data-src="{{ $product->image }}"
                    class="lazy {{ $isShowPage ? 'product-img-isShowPage' : 'product-img' }}" alt="">
            </span>
            @if (!$isShowPage && $hasStock && !$product->isFree())
                </span>
            @endif
            <div class="body">
                <div class="title"><a class="productName"
                        href="{{ route('store.product.show', $product) }}">{{ $product->name }}</a></div>
                <div class="quantity-area">
                    <span>{{ bnConvert()->number($product->quantity, false) }}
                        {{ bnConvert()->unit($product->unit) }}</span>
                </div>
                <div class="price-area">
                    ৳ <span class="price">{{ bnConvert()->number($product->price) }}</span>

                    @if ($product->price < $product->market_sale_price)
                        <span
                            style="color: #5E5E5E; font-weight: bold; font-size: 11px; margin-left: 3px; vertical-align: middle;"><del>৳
                                {{ bnConvert()->number($product->market_sale_price + $incMarketSalePrice) }}</del></span>
                    @endif

                </div>
                @if ($hasStock)
                    <div class="button-area">
                        @php
                            $cartQuantity = isset($count) ? $count : 0;
                        @endphp
                        @if ($cartQuantity <= 0)
                            <button wire:click="increment" class="btn btn-sm add-bag"><i class="fa fa-shopping-bag"></i>
                                ব্যাগে
                                রাখুন</button>
                        @else
                            <div class="bag-count-area">
                                @if (!$product->isFree())
                                    <button style="padding: 5px" wire:click="decrement"
                                        class="btn btn-sm btn-danger minus-quantity">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                @endif
                                @isset($count)
                                    <div class="QuantityTextContainer">
                                        <span class="badge"
                                            style="font-size: 13px; padding-bottom: 3px;">{{ bnConvert()->number($count, false) }}
                                            টি
                                            ব্যাগে
                                            <br />
                                            <span
                                                style="color: #f1f1f1; margin-top: 3px;padding-top: 3px;display:block;border-top: 1px solid #eeeeee; font-size: 12px;">৳
                                                {{ bnConvert()->number($product->price * $count) }}</span>
                                        </span>

                                    </div>
                                @endisset
                                @if ($product->isFree())
                                    <button style="padding: 5px;" wire:click="decrement"
                                        class="btn btn-sm btn-danger minus-quantity">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                                @if (!$product->isFree())
                                    <button style="padding: 5px;" wire:click="increment"
                                        class="btn btn-sm btn-success plusQuantity">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                @else
                    <div class="button-area">
                        <button class="btn btn-sm add-bag disabled" disabled style="background: #d35400"><i
                                class="fa fa-exclamation-triangle"></i> পণ্যটি স্টকে নেই </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if ($isShowPage)
</div>
<div class="col-md-6">
        <h1>{{$product->name}}</h1>
</div>
</div>
@endif
</div>
