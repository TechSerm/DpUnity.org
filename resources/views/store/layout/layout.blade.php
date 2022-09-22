<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="turbolinks-cache-control" content="no-cache">

    <link rel="stylesheet" href="{{ mix('css/store.css') }}">
    <style>
        .turbolinks-progress-bar {
            height: 0px;
            background-color: red;
        }
    </style>

    <title>@yield('title')</title>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false"></script>
    <script src="{{ mix('js/store.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.livewire.rescan();
        $(document).on('turbolinks:visit', function() {
            $("#loadBody").append($("#pageLoader").html());
        });

        window.addEventListener('change-cart-animation', event => {
            $("#mobile-cart-area").addClass("cart-animation");
            setTimeout(function() {
                $('#mobile-cart-area').removeClass('cart-animation');
            }, 5000);
        })
    </script>

    @livewireStyles
</head>

<body>
    @livewire('shop-footer')
    {{-- @include('store.layout.nav_test') --}}
    <div id="pageLoader" style="display: none">
        @include('store.layout.loader')
    </div>
    <div class="container" style="margin-top: 70px;" id="loadBody">
        @yield('content')
    </div>
    @include('store.layout.footer')
</body>
@stack('scripts')

</html>
