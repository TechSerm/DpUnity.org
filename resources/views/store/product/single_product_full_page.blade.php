@extends('store.layout.layout')
@section('content')

    <style>
        .discountLebel {
            position: absolute;
            text-align: center;
            color: #ffffff;
            margin-top: 10px;
            margin-left: -26px;
            background-color: #c0392b;
            width: 82px;
            transform: rotate(310deg);
            font-size: 12px;
            padding: 3px 0px 3px 3px;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .productName {
            color: #000000;

        }

        .productName:hover {
            outline: none;
            text-decoration: none;
        }

        .product-show .title {
            font-size: 18px;
            font-weight: bold;


        }

        .productLstImg {
            border: 1px solid #eeeeee;
        }

        .productLstImg:hover {
            cursor: pointer;
            border: 1px solid #aaaaaa;
        }

        .price {
            font-size: 30px;
            font-weight: bold;
            color: red;
        }

        .thumbnail-container {
            margin-top: 20px;
            overflow-x: scroll;
            /* Always show the scrollbar */
        }
    </style>


    @php
        $hasStock = $product->has_stock;
        $incMarketSalePrice = getProductDiscountIncValue($product->market_sale_price);
    @endphp

    <div class="product-show">

        <div class="row">
            <div class="col-md-6">
                <div class="store-card ">
                    <span class="ct-image-container">
                        <img id="productImage" style="width: 100%" src="{{ asset('assets/img/product_loader.gif') }}"
                            data-src="{{ $product->image }}" class="lazy product-img-isShowPage" alt="">
                    </span>
                    <div class="text-center mb-2 mt-2">
                        <div class="slider" id="thumbnail-slider">
                        @for ($i = 1; $i <= 7; $i++)
                            <img id="" style="height: 70px; width: 70px"
                                src="{{ asset('assets/img/product_loader.gif') }}" data-src="{{ $product->image }}"
                                class="lazy thumbnail productLstImg product-img-isShowPage" alt="">
                        @endfor
                        <img id="" style="height: 70px; width: 70px"
                            src="https://deencommerce.com/wp-content/uploads/2021/12/Jeans-Pant-Size-Dimensions.jpg"
                            data-src="https://deencommerce.com/wp-content/uploads/2021/12/Jeans-Pant-Size-Dimensions.jpg"
                            class="lazy thumbnail productLstImg product-img-isShowPage" alt="">
                        </div>
                        </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="store-card">
                    <div class="" style="border-bottom: 1px solid #eeeeee;padding: 10px;">
                        <span class="title">{{ $product->name }}</span><br />
                        Cagegory: <a href="">Test</a> <a href="">test</a>
                    </div>

                    <div class="price-area" style="padding: 10px;">
                        ৳ <span class="price">{{ bnConvert()->number($product->price) }}</span>

                        @if ($product->price < $product->market_sale_price)
                            <span
                                style="color: #5E5E5E; font-weight: bold; font-size: 11px; margin-left: 3px; vertical-align: middle;"><del>৳
                                    {{ bnConvert()->number($product->market_sale_price + $incMarketSalePrice) }}</del></span>
                        @endif

                        <div class="">
                            <div class="mb-2">
                                Quantity: - 1 +
                            </div>
                            <button class="btn btn-info">Buy Now</button>
                            <button class="btn btn-primary">Add To Cart</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="store-card product-show">
        <div class="header">
            Desciptions
        </div>
        <div class="body">
            hello this is system
        </div>
    </div>

@stop

@push('scripts')
<!-- Slick Carousel -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#thumbnail-slider').slick({
                infinite: true,
  slidesToShow: 3,
  slidesToScroll: 3,

    });

            // Handle thumbnail clicks
            $(".thumbnail").click(function() {
                // Get the clicked thumbnail's source
                var newImageSrc = $(this).attr("src");
                // Update the main product image with the clicked thumbnail
                $("#productImage").attr("src", newImageSrc);
            });
        });
    </script>
@endpush
