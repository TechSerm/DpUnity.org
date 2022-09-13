@php
$menuLinkList = [
    route('home') => route('cart'),
    route('cart') => route('order'),
];

$menuTextList = [
    route('home') => 'বাজার',
    route('cart') => 'অর্ডার পেইজে যান',
    route('order') => 'অর্ডার করুন',
];

$menuColorList = [
    route('home') => '#6c5ce7',
    route('cart') => '#1C8D73',
    route('order') => '#E03B8B',
];

$menuLinkUrl = isset($menuLinkList[$currentUrl]) ? $menuLinkList[$currentUrl] : '';
$menuText = isset($menuTextList[$currentUrl]) ? $menuTextList[$currentUrl] : '';
$color = isset($menuColorList[$currentUrl]) ? $menuColorList[$currentUrl] : '';

@endphp

<style>
    .cart-animation {
        opacity: 1;
        transform: scale(1);
        animation: jump 1s ease infinite;
    }

    @keyframes jump {
        33% {
            /* text-shadow: 0 5px #f37121, 0 5px #f2aaaa; */
            font-size: 18px;
        }

        50% {
            /* transform: translate(0, 0) rotate(-4deg); */
            /* text-shadow: 0 0px #8fc0a9, 0 0px #84a9ac; */
            font-size: 18px;
        }

        66.67% {
            /* text-shadow: 0 -5px #d54062, 0 -5px #8fc0a9; */
            font-size: 18px;
        }
    }
</style>

<div class="cart" style="background-color: {{ $color }}">
    <a href="{{ $menuLinkUrl }}">
        <div style="float: right; background: rgba(0,0,0,0.5); min-width: 30%">
            <div class="amount" style="width: 100%">
                <span style="display: block;" id="mobile-cart-area" class="">
                    ৳ {{ convertBanglaNumber($totalCartPrice) }}
                    <hr>
                    {{ convertBanglaNumber($totalCart) }} টি পণ্য
                </span>
            </div>
        </div>
        <div style="">
            <div class="status-area" style="background: rgba(0,0,0,0.1); min-width: 70%">
                {{ $menuText }}
            </div>
        </div>
    </a>
</div>
