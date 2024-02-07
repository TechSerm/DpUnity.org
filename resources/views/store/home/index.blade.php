@extends('store.layout.layout')
@section('title', theme()->title() . " - " .  theme()->slogan())
@section('content')
    
    <style>
        .loader-area {
            display: none;
            text-align: center;
        }

        .orderArea a {
            text-decoration: none;
        }

        .orderAreaCard {
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 5px;
            width: 100%;
            color: #000000;
            box-shadow: 0 2px 4px 0 #0d87a9, 0 3px 10px 0 #f8bbd0;
        }

        .orderArea .pending {
            background: #ffeaa7;
        }

        .orderArea .canceled {
            background: #fab1a0;
        }

        .orderArea .progressing {
            background: #a0b9e9;
        }

        .orderArea .complete {
            background: #7bed9f;
        }

        .orderAreaCard:hover {
            box-shadow: 0 2px 4px 0 #b11771, 0 3px 10px 0 #f8bbd0;
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

        .hotline-card {
            color: #000000;
            padding: 5px;
            box-shadow: 0 2px 4px 0 #aaaaaa, 0 3px 10px 0 #aaaaaa;
        }

        a:hover {
            outline: 0px;
        }

        .siteBanner {
            width: 100%;
            padding: 0px;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.01)
        }

        .siteBanner img {
            border-radius: 10px;
            max-height: 400px;
        }
    </style>

    <div class="siteBanner mb-3">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://icms-image.slatic.net/images/ims-web/787ada0a-40c9-4164-9ff3-15ad11e2e7a3.jpg_1200x1200.jpg"
                        class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://icms-image.slatic.net/images/ims-web/b1986946-079d-43f2-9317-ba524cb832a2.jpg"
                        class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://icms-image.slatic.net/images/ims-web/95207be7-e752-4577-9971-75a7be72fcd2.jpg"
                        class="d-block w-100" alt="...">
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
                <div style="background: #000000;border-radius: 3px; padding:  8px 2px 5px 2px;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </div>

            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                <div style="background: #000000;border-radius: 3px; padding:  8px 2px 5px 2px;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </div>
            </button>
        </div>
    </div>

    <style>
        .home-list {
            margin: 15px -5px 0px -5px;
            border: 1px solid #eeeeee;
            padding: 5px;
            border-radius: 5px;
        }

        .home-list-body {}

        .product:nth-child(3) {
            background: red;
        }

        .home-list-header {
            border: 1px solid #eeeeee;
            border-radius: 5px;
            font-weight: bold;
            font-size: 18px;
            padding: 10px;
            margin: -2px -2px 10px -2px;
        }

        .home-list-category-name {
            margin: 15px 10px 15px 0px;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 5px;
            font-weight: 500;
            font-size: 20px;
        }
    </style>
    {{-- @include('store.home.feedback_form') --}}

    <div class="store-card" style="margin-top: 30px">
        <div class="body" style="padding-top: 0px">
            <div class="home-list-category-name titleSpan mb-3">
                <i class="fa fa-list-alt" aria-hidden="true"></i> ক্যাটেগরি
            </div>
            @include('store.category.ui')
        </div>
    </div>
    <div class="store-card " style="margin-top: 30px;">
        <div class="body" style="padding-top: 0px">
            <div class="home-list-category-name titleSpan mb-3" style="font-weight: bold; color: var(--theme-color)">
                Hot Deals
                <div class="pull-right" >
                    <a href="{{ route('store.hot_deals') }}" style="color: var(--theme-color)">সকল হট ডিল</a> <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </div>
            </div>

            <div class="row no-gutters" style="" id="">
                @include('store.product.single_product_page', ['is_title_disable' => false, 'products' => $hotDealProducts])
            </div>
        </div>
    </div>
    {{-- <div class="home-list" style="background: #eaeffc"> --}}
    {{-- <div class="home-list-header" style="background: #3d579c; color: #ffffff">পণ্যের তালিকা</div> --}}
    <div class="home-list-body" style="margin-right: -10px;margin-top: 15px;">
        <div class="row no-gutters" style="" id="product-list">

            @include('store.product.single_product_page')
        </div>
        <div class="loader-area" id="loader-area">
            <img src="{{ asset('assets/img/loader.gif') }}" height="70px" width="70px" alt="">
        </div>
    </div>
    {{-- </div> --}}
    </div>

@stop

@push('scripts')
    <script>
        Store.home.init({
            url: "{{ route('store.home.products') }}"
        });
    </script>
@endpush
