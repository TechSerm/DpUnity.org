<div>
<div class="nav-mobile-footer-menu" style="" id="nav-menu">
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
            route('home') => '#6352b9',
            route('search') => '#6352b9',
            route('cart') => '#6352b9',
            route('store.order') => '#E03B8B',
        ];
        
        $isOrderPage = route('store.order') == $currentUrl;
        
        $path = parse_url($currentUrl, PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));
        $firstSegment = $segments[0];
        
        $menuLinkUrl = isset($menuLinkList[$currentUrl]) ? $menuLinkList[$currentUrl] : route('store.order');
        $menuText = isset($menuTextList[$currentUrl]) ? $menuTextList[$currentUrl] : 'অর্ডার পেইজে যান';
        $color = isset($menuColorList[$currentUrl]) ? $menuColorList[$currentUrl] : '#6352b9';
        $color1 = '#ffffff';
        
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
                font-size: 13px;
            }

            50% {
                /* transform: translate(0, 0) rotate(-4deg); */
                /* text-shadow: 0 0px #8fc0a9, 0 0px #84a9ac; */
                font-size: 13px;
            }

            66.67% {
                /* text-shadow: 0 -5px #d54062, 0 -5px #8fc0a9; */
                font-size: 13px;
            }
        }

        .buttonAreaTop {
            float: right;
            min-width: 80%;
            margin-right: 7%;

            @if ($totalCart >= 0)
                min-width: 46%;
                margin-right: -3px;
                margin-left: -10px;
            @endif
        }
    </style>

    @if ($totalCart < 0)
        <style>
            .mbutton {
                margin-right: 4px !important;
            }
        </style>
    @endif


    <div class="cart" style="background-color: {{ $color1 }}">
        <div class="buttonAreaTop" style="">
            <div class="button-area" style="color: black; font-size: 11px;">
                <a href="{{ route('store.order.list') }}">
                    <div class="mbutton {{ $firstSegment == 'order' ? 'mbuttonActive' : '' }}">
                        <img src="{{ asset('assets/img/order_icon.svg') }}"
                            alt="menu" style="width:22px;margin-bottom: 2px"><br />
                        অর্ডার
                    </div>
                </a>
                <a href="/categories" class="link">
                    <div class="mbutton  {{ $firstSegment == 'categories' ? 'mbuttonActive' : '' }}">
                        <img src="{{ asset('assets/img/categories_icon.svg') }}"
                            alt="menu" style="width:22px; margin-bottom: 2px"><br />
                        ক্যাটেগরি
                    </div>
                </a>
                <a href="/" class="">
                    <div class="mbutton {{ $firstSegment == '' ? 'mbuttonActive' : '' }}">
                        <i class="fa fa-home icon"></i><br />
                        হোম
                    </div>
                </a>
            </div>
        </div>

        <div style="float-left;">
            @if($totalCart > 0)
            <a href="{{ $menuLinkUrl }}" data-toggle="{{ $isOrderPage ? 'modal' : '' }}"
                data-target="{{ $isOrderPage ? '#orderDetailsModal' : '' }}">
            @endif
                <div class="status-area" style="background: {{ $color }};  {{ $totalCart > 0 ? "" : "opacity: 0.6;" }} width: 50%">
                    {{ $totalCart > 0 ? $menuText : "আপনার ব্যাগ খালি" }}

                    <div
                        style="float: right; background: rgba(0,0,0,0.5); min-width: 60px; border-radius: 5px; margin: -12px -7px 0px 0px">
                        <div class="amount" style="">
                            
                            @if ($totalCart > 0)
                            <span style="display: block; font-size: 12px" id="mobile-cart-area" class="">
                                ৳ {{ bnConvert()->number($totalCartPrice) }}
                                <hr>
                                {{ bnConvert()->number($totalCart) }} টি পণ্য
                            </span>
                            @else
                                <img src="{{ asset('assets/img/empty_bag_2.webp') }}" style="margin-top: -2px;" height="40px" alt="">
                            @endif
                        </div>
                    </div>
                </div>
            @if($totalCart > 0)
            </a>
            @endif
        </div>
    </div>
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
        .shoppingCartBag {
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
</div>