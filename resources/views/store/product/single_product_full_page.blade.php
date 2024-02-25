@extends('store.layout.layout')
@section('title', $product->name)
@section('content')

    <style>
        .productOrderBtn {
            padding: 10px 20px;
            border-width: 0px;
            color: #ffffff;
            border-radius: 5px;
            font-size: 17px;
        }

        .productOrderBtn:hover {
            color: #ffffff;
            opacity: 0.9;
        }

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

        .product-show-full .title {
            font-size: 22px;
            font-weight: bold;


        }

        .productLstImg {
            border: 1px solid #eeeeee;
            margin-top: 5px;
        }

        .productLstImg:hover {
            cursor: pointer;
            border-radius: 5px;
            border: 2px solid var(--theme-color) !important;
        }

        .price {
            font-size: 25px;
            font-weight: 700 !important;
            color: red;
        }

        .thumbnail-container {
            margin-top: 10px;
            padding-top: 2px;
            border-top: 1px solid #eff0f5;
        }

        .thumbnail-active {
            border-radius: 5px;
            border: 2px solid var(--theme-color) !important;
        }

        /*aiz megabox*/
        .aiz-megabox {
            position: relative;
            cursor: pointer;
        }

        .aiz-megabox input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .aiz-megabox .aiz-megabox-elem {
            border: 1px solid #dfdfe6;
            border-radius: 15px;
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        .aiz-megabox>input:checked~span .aiz-rounded-check:after,
        .aiz-megabox>input:checked~span .aiz-square-check:after {
            visibility: visible;
            opacity: 1;
        }

        .aiz-megabox>input:checked~.aiz-megabox-elem,
        .aiz-megabox>input:checked~.aiz-megabox-elem {
            border-color: #e74c3c;
            color: #e74c3c
        }

        .inc-area {
            border: 1px solid var(--theme-color);
            padding: 4px 2px 6px 3px;
            border-radius: 5px;
        }

        .fullSizeButton {
            width: 70%;
        }

        @media only screen and (max-width: 768px) {
            .fullSizeButton {
                width: 100%;
            }

            .description-body img {
                width: 100% !important;
            }
        }

        .product_code {
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-right: 10px solid #fff;
            display: inline-block;
            line-height: 0;
        }
    </style>

    <div class="product-show-full">

        <div class="row">
            <div class="col-md-5">
                <div class="store-card text-center ">
                    <span class="ct-image-container">
                        <img id="productImage" style="width: 330px;" src="{{ $product->image }}" class=" " alt="">
                    </span>
                    <div class="text-center mb-2 mt-2">
                        <div class="thumbnail-container">
                            <img id="" style="height: 70px; width: 70px"
                                src="{{ $product->image }}"
                                class="thumbnail thumbnail-active productLstImg" alt="">
                            @php
                                $images = $product->images;
                            @endphp
                            @foreach ($images as $image)
                                <img id="" style="height: 70px; width: 70px"
                                    src="{{ $image->url }}"
                                    class="thumbnail productLstImg " alt="">
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-7">
                <div class="store-card">
                    <div class="" style="padding: 10px;">
                        <span class="title">{{ $product->name }}</span>
                    </div>

                    <div class="" style="padding: 10px;">

                        <div class="price-a" style="margin: -10px -10px 0px -10px; padding: 10px;">
                            <span class="price">৳ {{ bnConvert()->number($product->sale_price) }}</span>
                            @if ($product->regular_price > $product->sale_price)
                                <span
                                    style="color: #5E5E5E; font-weight: bold; font-size: 18px; margin-left: 5px; vertical-align: middle;"><del>৳
                                        {{ bnConvert()->number($product->regular_price) }}</del></span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-white inline-block px-3 py-1 product_code theme-bg"
                            style=""><span>প্রোডাক্ট কোড: {{ $product->id }}</span></p>

                        {{-- <div class="row no-gutters mb-3">
                            <div class="col-sm-2">
                                <div class="text-secondary fs-14 fw-400 mt-2 ">
                                    Color Family
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="aiz-radio-inline">
                                    <label class="aiz-megabox pl-0 mr-2 mb-0">
                                        <input type="radio" name="attribute_id_2" value="Test" checked="">
                                        <span
                                            class="aiz-megabox-elem rounded-0 d-flex align-items-center justify-content-center py-1 px-3">
                                            Test
                                        </span>
                                    </label>
                                    <label class="aiz-megabox pl-0 mr-2 mb-0">
                                        <input type="radio" name="attribute_id_2" value="F2">
                                        <span
                                            class="aiz-megabox-elem rounded-0 d-flex align-items-center justify-content-center py-1 px-3">
                                            F2
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters mb-3">
                            <div class="col-sm-2">
                                <div class="text-secondary fs-14 fw-400 mt-2 ">
                                    Color
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="aiz-radio-inline">
                                    <label class="aiz-megabox pl-0 mr-2 mb-0">
                                        <input type="radio" name="attribute_id_1" value="Test" checked="">
                                        <span
                                            class="aiz-megabox-elem rounded-0 d-flex align-items-center justify-content-center py-1 px-3">
                                            Test
                                        </span>
                                    </label>
                                    <label class="aiz-megabox pl-0 mr-2 mb-0">
                                        <input type="radio" name="attribute_id_1" value="F2">
                                        <span
                                            class="aiz-megabox-elem rounded-0 d-flex align-items-center justify-content-center py-1 px-3">
                                            F2
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row no-gutters mb-3 mt-3">
                            <div class="col-sm-2">
                                <div class="text-secondary fs-14 fw-400">
                                    Quantity:
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <span class="inc-area">
                                    <button style="padding: 0px 5px; font-size: 15px" onclick="btnDec()"
                                        class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>
                                    <input type="text" value="1" id="quantityVal" hidden>
                                    <span style="margin-left: 10px; margin-right: 10px; font-weight: bold; font-size: 16px;"
                                        id="quantityArea">১</span>
                                    <button style="padding: 0px 5px;font-size: 15px" onclick="btnInc()"
                                        class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                        </div>

                        {{-- <div class="row no-gutters mb-3">
                            <div class="col-sm-2">
                                <div class="text-secondary fs-14 fw-400 mt-2 ">
                                    Total Price
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="aiz-radio-inline">
                                    <span class="price">৳ {{ bnConvert()->number($product->price) }}</span>
                                </div>
                            </div>
                        </div> --}}
                        <button data-product_id="{{ $product->id }}" data-csrf="{{ csrf_token() }}"
                            onclick="Store.cart.directOrder(this)" class="btn btn-sm productOrderBtn  theme-bg"><i
                                class="fa fa-cart"></i>
                            অর্ডার করুন
                        </button>
                        <button data-product_id="{{ $product->id }}" data-csrf="{{ csrf_token() }}"
                            onclick="Store.cart.addCartOrder(this)" class="btn btn-md productOrderBtn"
                            style="background: #16a085">কার্ট-এ যোগ
                            করুন</button><br />
                        <a href="tel:{{ theme()->mobile() }}" class="btn btn-md productOrderBtn mt-1 fullSizeButton" style="background: #2c3e50">ফোনে অর্ডার
                            করুনঃ {{ theme()->mobile() }}</a><br />
                        <button class="btn btn-md productOrderBtn fullSizeButton mt-1 mb-2"
                            style="background: #2980b9">ম্যাসেজের মাধ্যমে অর্ডার করতে
                            ক্লিক করুন</button>
                        <table class="table table-bordered fullSizeButton" style="font-size: 15px;">
                            <tr>
                                <td>ঢাকার ভিতরে ডেলিভারি</td>
                                <td><b>{{ bnConvert()->number(siteData()->inSideDhakaDeliveryFee()) }} ৳</td>
                            </tr>
                            <tr>
                                <td>ঢাকার বাইরে ডেলিভারি</td>
                                <td><b>{{ bnConvert()->number(siteData()->outSideDhakaDeliveryFee()) }} ৳</td>
                            </tr>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="store-card product-show">
        <div class="header" style="padding: 10px">
            Product Descriptions
        </div>
        <div class="body description-body" style="width: 100%;padding-left: 15px">
            {!! $product->description !!}
        </div>
    </div>

    <div class="store-card product-show">
        <div class="header" style="padding: 10px">
            Related Products
        </div>
        <div class="body" style="width: 100%;padding-left: 15px">
            <div class="row  no-gutters">
                @include('store.product.single_product_page', ['products' => $relatedProducts])
            </div>
        </div>
    </div>
    

@stop

@push('scripts')
    <!-- Slick Carousel -->
    <script>
        $(document).ready(function() {


            // Handle thumbnail clicks
            $(".thumbnail").click(function() {
                $(".thumbnail").removeClass("thumbnail-active");
                // Get the clicked thumbnail's source
                var newImageSrc = $(this).attr("src");
                // Update the main product image with the clicked thumbnail
                $("#productImage").attr("src", newImageSrc);
                $(this).addClass("thumbnail-active");
            });
        });

        function btnInc() {
            let quantityVal = parseInt($("#quantityVal").val()) + 1;

            $("#quantityArea").html(englishToBanglaNumber(quantityVal));
            $("#quantityVal").val(quantityVal);
        }

        function btnDec() {
            let quantityVal = parseInt($("#quantityVal").val()) - 1;

            if (quantityVal <= 0) quantityVal = 1;

            $("#quantityArea").html(englishToBanglaNumber(quantityVal));
            $("#quantityVal").val(quantityVal);
        }

        function englishToBanglaNumber(englishNumber) {
            const banglaNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

            // Convert each digit in the English number to the corresponding Bengali number
            const banglaNumber = englishNumber
                .toString()
                .split('')
                .map(digit => banglaNumbers[parseInt(digit)])
                .join('');

            return banglaNumber;
        }
    </script>
@endpush
