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

        .productName .title:hover {
            color: var(--theme-color);
        }

        .product-order-btn:hover{
            font-size: 16px;
            color: var(--theme-font-color);
            
        }

        .product:hover {
            border: 1px solid var(--theme-color);
        }
    </style>


    <div class="" style="text-align: center">
        <div class="card product product-div">

            <a class="productName" href="{{ route('store.product.show', ['product' => $product->slug]) }}">
                <span class="ct-image-container">
                    <img id="productImage" src="{{ asset('assets/img/product_loader.gif') }}"
                        data-src="{{ $product->image }}"
                        class="lazy product-img" alt="">
                </span>
            </a>

            <div class="body">
                <a class="productName" href="{{ route('store.product.show', ['product' => $product->slug]) }}">
                    <div class="title"><span class="">{{ $product->short_name }}</span></div>
                </a>
                <div class="price-area">
                    ৳ <span class="price">{{ bnConvert()->number($product->sale_price) }}</span>

                    @if ($product->regular_price > $product->sale_price)
                        <span
                            style="color: #5E5E5E; font-weight: bold; font-size: 11px; margin-left: 3px; vertical-align: middle;"><del>৳
                                {{ bnConvert()->number($product->regular_price) }}</del></span>
                    @endif
                </div>
                <div class="button-area">
                    <button data-product_id="{{$product->id}}" data-csrf="{{csrf_token()}}" onclick="Store.cart.directOrder(this)" class="btn btn-sm product-order-btn add-bag  theme-bg"><i class="fa fa-cart"></i> অর্ডার করুন </button>
                </div>
            </div>
        </div>
    </div>
</div>
