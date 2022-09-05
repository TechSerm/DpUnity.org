@extends('store.layout.layout')

@section('content')

    <style>
        .loader-area {
            display: none;
            text-align: center;
        }
    </style>

    <div class="row" id="product-list">

        @livewire('shop-products')

    </div>
    <div class="loader-area" id="loader-area">
        <img src="https://i.gifer.com/origin/b4/b4d657e7ef262b88eb5f7ac021edda87.gif" alt="">
    </div>
    
@stop

@push('scripts')
    <script>
        let page = 2;
        let pageStop = false;
        let pageLoading = false;
        $(window).scroll(function() {

            // if ($(this).scrollTop() + 10 >= $('body').height() - $(window).height() && pageStop === false) {
            //     page++;
            //     $("#loader-area").show();

            // }
        });

        $(document.body).on('touchmove', onScroll); // for mobile
        $(window).on('scroll', onScroll);

        function onScroll() {
            if ($(window).scrollTop() + window.innerHeight + 10 >= document.body.scrollHeight) {
                load_contents();
            }
        }

        function load_contents() {
            if(pageLoading === true || pageStop === true)return;
            page ++;
            pageLoading = true;
            $("#loader-area").show();
            //alert("new page load " + page);
            $.get("{{ route('store.home.products') }}" + "?page=" + page, function(response) {
                $("#product-list").append(response);
                $("#loader-area").hide();
                pageStop = response == "" ? true : false;
                pageLoading = false;
                window.livewire.rescan();
            });
        }
    </script>
@endpush

