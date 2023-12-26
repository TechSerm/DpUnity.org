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


    @php
        $hasStock = $product->has_stock;
        $incMarketSalePrice = getProductDiscountIncValue($product->market_sale_price);
    @endphp
    <a class="productName" href="{{ route('store.product.show', $product) }}">
        <div class="" style="text-align: center">
            <div class="card product product-div">
                
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
                    <div class="title"><span class="">{{ $product->name }}</span></div>

                    <div class="price-area">
                        ৳ <span class="price">{{ bnConvert()->number($product->price) }}</span>

                        @if ($product->price < $product->market_sale_price)
                            <span
                                style="color: #5E5E5E; font-weight: bold; font-size: 11px; margin-left: 3px; vertical-align: middle;"><del>৳
                                    {{ bnConvert()->number($product->market_sale_price + $incMarketSalePrice) }}</del></span>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
