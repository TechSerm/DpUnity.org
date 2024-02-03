@extends('store.layout.layout')
@section('content')

    <style>

        .productOrderBtn {
            padding: 12px;
            border-width: 0px;
            color: #ffffff;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
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

        .product-show .title {
            font-size: 22px;
            font-weight: bold;


        }

        .productLstImg {
            border: 1px solid #eeeeee;
            margin-top: 5px;
        }

        .productLstImg:hover {
            cursor: pointer;
            border: 2px solid #aaaaaa;
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
    </style>

    <div class="product-show">

        <div class="row">
            <div class="col-md-5">
                <div class="store-card text-center ">
                    <span class="ct-image-container">
                        <img id="productImage" style="width: 330px;" src="{{ asset('assets/img/product_loader.gif') }}"
                            data-src="{{ $product->image }}" class="lazy product-img-isShowPage" alt="">
                    </span>
                    <div class="text-center mb-2 mt-2">
                        <div class="thumbnail-container">
                            @for ($i = 1; $i <= 3; $i++)
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
            <div class="col-md-7">
                <div class="store-card">
                    <div class="" style="padding: 10px;">
                        <span class="title mb-2">{{ $product->name }}</span>
                    </div>

                    <div class="price-area" style="padding: 10px;">

                        <div class="price-a" style="margin: -10px -10px 15px -10px; padding: 10px;">
                            <span class="price">৳ {{ bnConvert()->number($product->sale_price) }}</span>
                            @if ($product->regular_price > $product->sale_price)
                                <span
                                    style="color: #5E5E5E; font-weight: bold; font-size: 18px; margin-left: 5px; vertical-align: middle;"><del>৳
                                        {{ bnConvert()->number($product->regular_price) }}</del></span>
                            @endif
                        </div>

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
                        <div class="row no-gutters mb-3">
                            <div class="col-sm-2">
                                <div class="text-secondary fs-14 fw-400 mt-2 ">
                                    Quantity
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="aiz-radio-inline">
                                    - 1 +
                                </div>
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
                            onclick="Store.cart.directOrder(this)" class="btn btn-sm productOrderBtn  theme-bg"><i class="fa fa-cart"></i>
                            অর্ডার করুন 
                        </button>
                        <button class="btn btn-md productOrderBtn" style="background: #16a085">কার্ট-এ যোগ করুন</button><br />
                        <a class="btn btn-md productOrderBtn mt-1" style="width: 400px;background: #2c3e50">ফোনে অর্ডার করুনঃ 01958452421</a><br />
                        <button class="btn btn-md productOrderBtn mt-1 mb-2" style="width: 400px; background: #2980b9">ম্যাসেজের মাধ্যমে অর্ডার করতে
                            ক্লিক করুন</button>
                        <table class="table table-bordered" style="max-width: 400px;">
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
    <script>
        $(document).ready(function() {


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
