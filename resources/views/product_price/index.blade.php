@extends('layouts.app')
@section('content_header')
    <h1>Products Price Update</h1>
@stop
@section('content')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css">
    <style>
        .productPriceInput {
            font-weight: bold;
            font-size: 15px;
            color: #000000;
        }

        .productPriceCard {
            padding: 5px 10px 10px 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .cartTr {
            /* box-shadow: 0px 0px 5px rgba(70, 8, 86, 0.3);  */
            border: 1px dashed #eeeeee;
            border-width: 0px 0px 1px 0px !important;
            margin-bottom: 6px;
            display: table-row;
            width: 100%;
        }

        .cartTr td {
            /* border: 1px solid #000000; */
        }

        footer {
            position: fixed;
            height: 60px;
            bottom: 0;
            width: 100%;
            border: 1px solid #c5c5c5;
            background: #aaaaaa;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            padding: 5px;
        }

        .btn-product-price {
            font-size: 18px;
            padding: 10px;
            font-weight: bold;
        }

        /* toggle */
        .toggle {
            --width: 70px;
            --height: calc(var(--width) / 3);

            position: relative;
            display: inline-block;
            width: var(--width);
            height: var(--height);
            border-radius: var(--height);
            cursor: pointer;
            margin-top: 5px;
        }

        .toggle input {
            display: none;
        }

        .toggle .slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 5px;
            background: #e74c3c;
            border: 1px solid #c0392b;
            transition: all 0.4s ease-in-out;
        }

        

        .toggle .slider::before {
            content: "";
            position: absolute;
            top: 3.5px;
            left: 3px;
            width: calc(var(--height)*0.6);
            height: calc(var(--height)*0.6);
            border-radius: 5px;
            border: 1px solid #eeeeee;
            background-color: #ffffff;
            transition: all 0.4s ease-in-out;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .toggle input:checked+.slider {
            border-color: #23a258;
            background: #27ae60;
        }

        .toggle input:checked+.slider::before {
            border-color: #eeeeee;
            background-color: #ffffff;
            left: 6px;
            transform: translateX(calc(var(--width) - var(--height)));
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .toggle .labels {
            position: absolute;
            top: 4px;
            left: 0;
            width: 100%;
            height: 100%;
            color: #4d4d4d;
            font-size: 11px;
            color: #ffffff;
            transition: all 0.4s ease-in-out;
        }

        .toggle .labels::after {
            content: attr(data-off);
            position: absolute;
            right: 5px;
            opacity: 1;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
            transition: all 0.4s ease-in-out;
        }

        .toggle .labels::before {
            content: attr(data-on);
            position: absolute;
            left: 5px;
            opacity: 0;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.4);
            transition: all 0.4s ease-in-out;
        }

        .toggle input:checked~.labels::after {
            opacity: 0;
        }

        .toggle input:checked~.labels::before {
            opacity: 1;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card productPriceCard" style="padding: 15px;">
                <div class="row">
                    <div class="col-md-3">
                        <label>পণ্যের নাম</label>
                        <input type="text"
                            value="{{ isset(request()->product_name) && request()->product_name ? request()->product_name : '' }}"
                            placeholder="পণ্যের নাম লিখুন" class="form-control mb-1" id="product_name" id="">
                    </div>
                    <div class="col-md-3">
                        <label>ক্যাটেগরি</label>
                        <select name="category_id" class="form-control mb-1" id="category">
                            <option value="">ক্যাটেগরি নির্বাচন করুন</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ isset(request()->category) && request()->category == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary mt-2" onclick="filterProduct()" type="submit">ফিল্টার করুন</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" data-function="updateProductPrice(form)">
        @csrf
        <div class="row">
            @foreach ($products as $product)
            
                <div class="col-md-3">
                    <div class="card productPriceCard">
                        <table>
                            <tr class="cartTr">
                                <td class="align-middle" style="padding: 5px; width: 70px">
                                    <small> <img src="{{ $product->image }}" height="70px" width="70px" alt="">
                                </td>
                                <td class="align-middle" style="text-align: left">
                                    <div class="" style="font-size: 13px;font-weight: bold">
                                        {{$product->id}} - {{ $product->name }}
                                    </div>
                                    <div style="font-size: 11px;font-weight: bold; color: #767575">
                                        {{ bnConvert()->number($product->quantity) }}
                                        {{ bnConvert()->unit($product->unit) }}

                                        <span class="badge {{$product->status == 'private' ? 'badge-danger' : 'badge-success'}}">{{$product->status}}</span>
                                        
                                        <span class="badge badge-info">{{$product->vendor->name ?? ''}}</span>
                                        <br />
                                        
                                        <label class="toggle">
                                            <input type="checkbox" data-product_id="{{ $product->id }}"
                                                data-default-value="{{ $product->has_stock }}"
                                                name="productHasStock[{{ $product->id }}]"
                                                {{ $product->has_stock ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                            <span class="labels" data-on="স্টকে আছে" data-off="স্টকে নাই"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="row mt-2">
                            <input type="number" name="product_id[]" value="{{ $product->id }}" id="" hidden>
                            <div class="col-md-6 col-6">
                                <small class="" style="font-weight: bold;">পাইকারি মূল্য</small>
                                <input type="number" data-product_id="{{ $product->id }}"
                                    data-default-value="{{ $product->wholesale_price }}" name="wholesale_price[]"
                                    class="productPriceInput form-control mb-1" value="{{ $product->wholesale_price }}">
                            </div>
                            <div class="col-md-6 col-6">
                                <small class="" style="font-weight: bold;">বাজার দর</small>
                                <input type="number" data-product_id="{{ $product->id }}"
                                    data-default-value="{{ $product->market_sale_price }}" name="market_sale_price[]"
                                    class="productPriceInput form-control mb-1" value="{{ $product->market_sale_price }}">
                            </div>
                            <div class="col-md-12">
                                <small><b>সর্বশেষ পরিবর্তন হয়েছে:</b>
                                    {{ bnConvert()->date(($product->wholesale_price_last_update ? $product->wholesale_price_last_update : $product->updated_at)->diffForHumans()) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div style="overflow: hidden; font-size: 10px;">
            {{ $products->onEachSide(1)->links() }}
        </div>
        <div style="margin-bottom: 150px; "></div>
        <footer class="fixed-bottom"><button type="submit" id="priceSubmitBtn" style="width: 100%"
                class="btn btn-product-price btn-success" disabled>আপডেট করুন </button></footer>
    </form>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
    <script>
        var activeButton = false;
        var mismatchPrice = {
            wholesalePrice: [],
            marketSalePrice: [],
            hasStock: []
        };
        $(document).ready(function() {
            $("input[name^='wholesale_price']").keyup(function(e) {
                togglePrice("wholesalePrice", $(this).data('product_id'), $(this).data('default-value'), $(
                    this).val());
            });

            $("input[name^='market_sale_price']").keyup(function(e) {
                togglePrice("marketSalePrice", $(this).data('product_id'), $(this).data('default-value'), $(
                    this).val());
            });

            $("input[name^='productHasStock']").change(function(e) {
                let isChecked = $(this).prop("checked");
                togglePrice("hasStock", $(this).data('product_id'), $(this).data('default-value'), isChecked);
            });
        });

        function togglePrice(type, productId, oldPrice, newPrice) {
            if (oldPrice != newPrice) {
                let index = mismatchPrice[type].indexOf(productId);
                if (index === -1) mismatchPrice[type].push(productId);

            } else {
                let index = mismatchPrice[type].indexOf(productId);
                if (index !== -1) mismatchPrice[type].splice(index, 1);
            }

            activeButton = mismatchPrice['wholesalePrice'].length === 0 && mismatchPrice['marketSalePrice'].length === 0 &&
                mismatchPrice['hasStock'].length === 0 ?
                false : true;

            if (activeButton == true) $("#priceSubmitBtn").prop("disabled", false);
            else $("#priceSubmitBtn").prop("disabled", true);
        }

        function updateProductPrice(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    'callback': function() {
                        location.reload();
                    }
                }
            });
        }

        function filterProduct() {
            let productName = $("#product_name").val();
            let category = $("#category").val();

            var url = new URL("{{route('product_price.index')}}");
            url.searchParams.set('product_name', productName);
            url.searchParams.set('category', category);

            window.location.href = url;
        }

        $('#product_name').autoComplete({
            cache: false,
            minChars: 1,
            source: function(term, response) {
                let productName = $('#product_name').val();
                $.getJSON('{{ route('product.name_suggestions') }}', {
                    query: productName
                }, function(data) {
                    response(data);
                });
            }
        });
    </script>
@endpush
