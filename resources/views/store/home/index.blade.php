@extends('store.layout.layout')
@section('content')

    <style>
        .loader-area {
            display: none;
            text-align: center;
        }

        .searchArea {
            position: fixed;
            z-index: 1500;
            background: #ffffff;
            width: 100%;
            margin: -15px 0px -0px -15px;
            text-align: center
        }
        .searchArea input {
            padding: 5px;
            width: 80%;
        }
    </style>
    <div class="row no-gutters" style="margin: 15px -15px 0px -5px;" id="product-list">
        @include('store.product.single_product_page')
    </div>
    <div class="loader-area" id="loader-area">
        <img src="https://i.gifer.com/origin/b4/b4d657e7ef262b88eb5f7ac021edda87.gif" height="70px" width="70px" alt="">
    </div>

@stop

@push('scripts')
    <script>
        $(document.body).on('touchmove', onScroll); // for mobile
        $(window).on('scroll', onScroll);

        Store.home.init();

        function onScroll() {
            if ($(window).scrollTop() + window.innerHeight + 10 >= document.body.scrollHeight) {
                Store.home.loadHomeProduct("{{ route('store.home.products') }}");
            }
        }

    </script>
@endpush
