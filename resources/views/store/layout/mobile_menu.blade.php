<div class="nav-mobile-footer-menu" style="{{ $totalCart > 0 ? '' : 'display: none' }}" id="nav-menu">
    @php
        $menuLinkList = [
            route('home') => route('store.order'),
            route('search') => route('store.order'),
            route('cart') => route('cart'),
        ];
        
        $menuTextList = [
            route('home') => 'অর্ডার পেইজে যান',
            route('search') => 'অর্ডার পেইজে যান',
            route('cart') => 'অর্ডার করুন',
            route('store.order') => 'অর্ডার করুন',
        ];
        
        $menuColorList = [
            route('home') => '#1C8D73',
            route('search') => '#1C8D73',
            route('cart') => '#E03B8B',
            route('store.order') => '#E03B8B',
        ];
        
        $isOrderPage = route('store.order') == $currentUrl;
        
        $menuLinkUrl = isset($menuLinkList[$currentUrl]) ? $menuLinkList[$currentUrl] : route('store.order');
        $menuText = isset($menuTextList[$currentUrl]) ? $menuTextList[$currentUrl] : 'অর্ডার পেইজে যান';
        $color = isset($menuColorList[$currentUrl]) ? $menuColorList[$currentUrl] : '#1C8D73';
        
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
                font-size: 15px;
            }

            50% {
                /* transform: translate(0, 0) rotate(-4deg); */
                /* text-shadow: 0 0px #8fc0a9, 0 0px #84a9ac; */
                font-size: 15px;
            }

            66.67% {
                /* text-shadow: 0 -5px #d54062, 0 -5px #8fc0a9; */
                font-size: 15px;
            }
        }
    </style>

    @if ($totalCart > 0)
        @php
            $cartPage;
        @endphp
        <div class="cart" style="background-color: {{ $color }}">
            <a href="{{ $menuLinkUrl }}" data-toggle="{{ $isOrderPage ? 'modal' : '' }}"
                data-target="{{ $isOrderPage ? '#orderDetailsModal' : '' }}">
                <div style="float: right; background: rgba(0,0,0,0.5); min-width: 30%">
                    <div class="amount" style="width: 100%">
                        <span style="display: block; font-size: 14px" id="mobile-cart-area" class="">
                            ৳ {{ bnConvert()->number($totalCartPrice) }}
                            <hr>
                            {{ bnConvert()->number($totalCart) }} টি পণ্য
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
    @endif

</div>
<style>
    .la-shopping-bag:before {
        content: "\f290";
    }

    .shoppingCartBag {
        width: 80px;
        height: 80px;
        color: #fdd670;
        background-color: #55584d;
        position: fixed;
        z-index: 999;
        right: 0;
        top: 50%;
        box-shadow: 0 0 16px -1px rgb(0 0 0 / 75%);
        transform: translateY(-50%);
        margin: 0px 0px 5px;
    }

    @media screen and (max-width: 767px) {
        .shoppingCartBag{
            display: none;
        }
    }
</style>

<a href="{{ route('store.order') }}">
    <div class="shoppingCartBag text-center pt-2" role="button">
        <div>
            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
        </div>
        <p><span class="cart-count">{{ bnConvert()->number($totalCart) }}</span> টি পণ্য</p>
        <h6 class="bg-white cart-total">৳ {{ bnConvert()->number($totalCartPrice) }}</h6>
    </div>
</a>
