<div>
    <style>
        
    </style>
    @if ($isShowPage)
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
    @endif

    <div class="card product" style="height: {{ $isShowPage == true ? '500' : '300' }}px">
        @if (!$isShowPage)
        <span href="#" wire:click="increment" class="">
        @endif
            <span class="ct-image-container">
                <img width="100%" id="productImage" height="{{ $isShowPage == true ? '350' : '150' }}px" src="{{ $product->image }}"
                    class="" alt="">
            </span>
        @if (!$isShowPage)
        </span>
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
                @if ($cartQuantity <= 0)
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
