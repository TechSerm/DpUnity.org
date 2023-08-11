<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="turbolinks-cache-control" content="no-cache">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/fav.png') }}">
    <title>বিবিসেনা অনলাইন শপ </title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <script>
        window.livewire.rescan();

        $(document).on('turbolinks:visit', function() {
            $("#loadBody").append($("#pageLoader").html());
        });

        $(window).resize(function() {
            Store.home.updateProductImageSize();
            Store.menu.initSidebar(true);
        });

        window.addEventListener('change-cart-animation', event => {
            $("#mobile-cart-area").addClass("cart-animation");
            setTimeout(function() {
                $('#mobile-cart-area').removeClass('cart-animation');
            }, 5000);
        })

        window.addEventListener('order-confirm-modal', event => {
            //alert("Working");
            $('#orderDetailsModal').addClass("show").css("display", "block");
            // $('#orderDetailsModal').modal('toggle');
        })

        window.addEventListener('livewire:load', function() {
            Livewire.on('cartUpdate', function() {
                Store.home.updateProductImageSize();
            });
        });
    </script>

    @livewireStyles
</head>
@include('store.layout.sidebar')

<body>

    @include('store.layout.navbar')
    
    <div id="pageLoader" style="display: none">
        @include('store.layout.loader')
    </div>

    <div class="containerr storeContent" style="margin-top: 60px; padding: 15px;" id="loadBody">
        @yield('content')
    </div>
    @include('store.layout.footer')
</body>
@stack('scripts')

<script>
    Store.home.updateProductImageSize();

</script>

</html>
