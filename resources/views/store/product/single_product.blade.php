<div class="card product mb-4" style="height: 300px" data-url="https://bibisena.com/bn/">
    <a href="" class="">
        <span class="ct-image-container">
            <img width="100%" height="150px" src="{{ $product->image }}" class="" alt="">
        </span>
        <h5 class="woocommerce-loop-product__title">{{ $product->name }}</h5>
        <span class="price">
            <span class="woocommerce-Price-amount amount"><bdi>{{ convertBanglaNumber($product->price) }}<span
                        class="woocommerce-Price-currencySymbol">৳&nbsp;</span></bdi>
            </span>
        </span>
    </a>
    <div style="text-align: center">
        @php
            $cartQuantity = isset($count) ? $count : 0;
        @endphp
        @if ($cartQuantity == 0)
            <button wire:click="increment" class="btn btn-sm btn-primary">ব্যাগে রাখুন</button>
        @else
            <button style="padding: 5px" wire:click="increment" class="btn btn-sm btn-primary">+</button>
            @isset($count)
                {{ convertBanglaNumber($count) }} টি ব্যাগে
            @endisset
            <button style="padding: 5px;" wire:click="decrement" class="btn btn-sm btn-danger">-</button>
        @endif
    </div>

    </a>

</div>
