<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="turbolinks-cache-control" content="no-cache">
    <link rel="icon" type="image/x-icon" href="{{ theme()->favicon() }}">
    <title> @yield("title") - {{ theme()->title() }}  </title>
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
    <link rel="stylesheet" href="/vendor/fontawesome-free/css/all.min.css">

    <script>
        window.livewire.rescan();

        $(document).ready(function() {
            var lazyloadThrottleTimeout;
            $(window).on("scroll resize", function() {
                if (lazyloadThrottleTimeout) {
                    clearTimeout(lazyloadThrottleTimeout);
                }
                lazyloadThrottleTimeout = setTimeout(lazyloadImages, 50);
            });
        });

        function lazyloadImages() {
            let imgList = $("img.lazy");
            if (imgList.length == 0) return;
            let scrollTop = $(window).scrollTop();
            let windowHeight = $(window).height();
            imgList.each(function() {
                var img = $(this);
                if (img.offset().top < (scrollTop + windowHeight + 120)) {
                    img.attr("src", img.data("src")).removeClass("lazy");
                }
            });
        }

        $(document).on('turbolinks:visit', function() {
            //$("#loadBody").append($("#pageLoader").html());
        });

        $(document).on('turbolinks:load', function() {
            lazyloadImages();
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
                lazyloadImages();
            });
        });
    </script>

    @livewireStyles
</head>

<body>

    @include('store.layout.navbar')
    @include('store.layout.theme_style')

    <div id="pageLoader" style="display: none">
        @include('store.layout.loader')
    </div>
    @yield('fullContant')
    <div class="container-fluid container storeContent" id="loadBody">
        @yield('content')
    </div>
    @include('store.layout.footer')
</body>
@stack('scripts')

<script>
    Store.home.updateProductImageSize();
    Helper.initBodyAction();
</script>

</html>
