<div>
    <style>
        .product {
            background-color: #fff;
            border: none;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            margin-right: 10px;
            padding: 2px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .product img {
            border-radius: 5px;
        }

        .product .body {
            /* background: black; */
            padding: 2px;
            font-size: 15px;
            text-align: center;
            height: 100%;
        }

        .product .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin: 0px 0px 3px 0px;
            padding-top: 5px;
            color: black;
            height: 50px;
            /* background: red; */
            overflow: hidden;
            line-height: 15px;
        }

        .product .quantity-area {
            height: 20px;
            /* background: blue; */
            font-size: 13px;
            color: #2c3e50;
        }

        .product .price-area {
            height: 20px;
            /* background: green; */
            margin-bottom: 3px;
            color: red;
        }

        .product .price {
            color: #e43215;
            font-weight: 700;
            font-size: 18px;
        }

        .product .button-area {
            text-align: center;
            height: 40px;
            margin-top: 10px;
            vertical-align: middle;

        }

        .product button:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .product .add-bag {
            width: 100%;
            border-radius: 5px;
            height: 100%;
            background-color: #8e44ad;
            font-size: 16px;
            color: #fff;
        }

        .product .bag-count-area {
            background: #3498db;
            height: 100%;
            border-radius: 5px;
            color: #fff;
        }

        .product .minus-quantity {
            float: left;
            border-right: 1px solid #d55f5f;
            border-radius: 5px 0 0 5px;
            width: 30px;
            height: 100%;
        }

        .product .QuantityTextContainer {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            line-height: 36px;

            padding-top: 2px;
            vertical-align: middle;
            overflow: hidden;
        }

        .product .plusQuantity {
            border: none;
            width: 30px;
            background: #2ecc71;
            border-radius: 0px 5px 5px 0px;
            height: 100%;
            font-weight: 700;
            color: #fff;
            float: right;
        }
    </style>
    @if ($isShowPage)
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
    @endif

    <div class="card product" style="height: {{ $isShowPage == true ? '500' : '300' }}px">
        @if (!$isShowPage)
        <a href="{{ route('store.product.show', ['product' => $product->id]) }}" class="">
        @endif
            <span class="ct-image-container">
                <img width="100%" id="productImage" height="{{ $isShowPage == true ? '350' : '150' }}px" src="{{ $product->image }}"
                    class="" alt="">
            </span>
        @if (!$isShowPage)
        </a>
        @endif
        <div class="body">
            <div class="title">{{ $product->name }}</div>
            <div class="quantity-area">
                <span>{{ bnConvert()->number($product->quantity, false) }}
                    {{ bnConvert()->unit($product->unit) }}</span>
            </div>
            <div class="price-area">
                ৳ <span class="price">{{ bnConvert()->number($product->price) }}</span>
            </div>

            <div class="button-area">
                @php
                    $cartQuantity = isset($count) ? $count : 0;
                @endphp
                @if ($cartQuantity == 0)
                    <button wire:click="increment" class="btn btn-sm add-bag"><i class="fa fa-shopping-bag"></i> ব্যাগে
                        রাখুন</button>
                @else
                    <div class="bag-count-area">
                        <button style="padding: 5px" wire:click="decrement"
                            class="btn btn-sm btn-danger minus-quantity">
                            <i class="fa fa-minus"></i>
                        </button>
                        @isset($count)
                            <div class="QuantityTextContainer">
                                <span class="badge"
                                    style="font-size: 13px; padding-bottom: 3px;">{{  bnConvert()->number($count, false) }} টি
                                    ব্যাগে
                                    <br />
                                    <span
                                        style="color: #f1f1f1; margin-top: 3px;padding-top: 3px;display:block;border-top: 1px solid #eeeeee; font-size: 12px;">৳
                                        {{ bnConvert()->number($product->price * $count) }}</span>
                                </span>

                            </div>
                        @endisset
                        <button style="padding: 5px;" wire:click="increment"
                            class="btn btn-sm btn-success plusQuantity">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@if ($isShowPage)
</div>
<div class="col-md-3"></div>
</div>
@endif
</div>
