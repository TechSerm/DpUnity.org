@extends('layouts.app')
@section('content_header')
    <h1>Products Price Update</h1>
@stop
@section('content')
    <style>
        .productPriceInput {
            font-weight: bold;
            font-size: 15px;
            color: #000000;
        }

        .productPriceCard {
            padding: 0px 10px 10px 10px;
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
    </style>
    
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
                                        {{ $product->name }}
                                    </div>
                                    <div style="font-size: 11px;font-weight: bold; color: #767575">
                                        {{ bnConvert()->number($product->quantity) }}
                                        {{ bnConvert()->unit($product->unit) }}
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
                                <input type="number" data-product_id="{{ $product->id }}" data-default-value="{{ $product->market_sale_price }}" name="market_sale_price[]" class="productPriceInput form-control mb-1"
                                    value="{{ $product->market_sale_price }}">
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
        <div style="margin-bottom: 80px;">
            {{ $products->links() }}
        </div>
        <footer class="fixed-bottom"><button type="submit" id="priceSubmitBtn" style="width: 100%"
                class="btn btn-product-price btn-success" disabled>দাম
                আপডেট করুন </button></footer>
    </form>
@endsection
@push('scripts')
    <script>
        var activeButton = false;
        var mismatchPrice = {
            wholesalePrice: [],
            marketSalePrice: []
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
        });

        function togglePrice(type, productId, oldPrice, newPrice) {
            if (oldPrice != newPrice) {
                let index = mismatchPrice[type].indexOf(productId);
                if (index === -1) mismatchPrice[type].push(productId);

            } else {
                let index = mismatchPrice[type].indexOf(productId);
                if (index !== -1) mismatchPrice[type].splice(index, 1);
            }

            activeButton = mismatchPrice['wholesalePrice'].length === 0 && mismatchPrice['marketSalePrice'].length === 0 ?
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
    </script>
@endpush
