@php
    $items = $order->items;
@endphp



<style>
    .orderPcVersion {
        display: block;
    }

    .orderMobileVersion {
        display: none;
    }

    @media only screen and (max-width: 767px) {
        .orderPcVersion {
            display: none;
        }

        .orderMobileVersion {
            display: block;
        }
    }
</style>

<div class="orderDetails mb-3">
    <div class="header" style="background: #16a085">
        অর্ডারকৃত পণ্য
    </div>
    <div class="body">
        <div class="float-right">
            @if ($order->isEditable())
                
            
            <a data-toggle="modal" data-modal-size="600" data-modal-header="Add New Product"
                                    href="{{ route('order_items.create', request()->route()->parameters()) }}"
                                  class="btn btn-success mb-2"><i class="fas fa-pencil-alt"></i> Add Product</a>
            @endif
        </div>
        <div class="orderPcVersion">
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>পণ্যের ছবি</th>
                    <th style="text-align: left">পণ্য</th>
                    <th>মূল্য</th>
                    <th>পরিমান</th>
                    <th>সর্বমোট মূল্য</th>
                </tr>
                @foreach ($items as $key => $item)
                    @php
                        $product = $item->product;
                        $attr = array_merge(
                            request()
                                ->route()
                                ->parameters(),
                            ['order_item' => $item->uuid],
                        );
                    @endphp
                    <tr>
                        <td style="width: 30px">{{ bnConvert()->number($key + 1) }}</td>
                        <td style="width: 80px">
                            <img src="{{ $item->product->image }}" height="70px" width="70px" alt="">
                        </td>
                        <td style="text-align: left">
                            <div class="" style="font-size: 13px;font-weight: bold">
                                <a data-toggle="modal" data-modal-size="md"
                                    data-modal-header="Product #{{ $item->product_id }}"
                                    href="{{ route('products.show', ['product' => $item->product_id]) }}">{{ $item->name }}</a>
                            </div>
                            <div style="font-size: 11px;font-weight: bold; color: #767575">৳
                                {{ convertBanglaNumber($item->price) }}
                                / {{ bnConvert()->number($item->unit_quantity, false) }}
                                {{ bnConvert()->unit($item->unit) }} </div>
                            <div style="margin-top: 2px;">
                                @if ($order->isEditable())
                                <a data-toggle="modal" data-modal-header="Update Order Item #{{ $key + 1 }}"
                                    href="{{ route('order_items.edit', $attr) }}" style="padding: 2px 4px 2px 4px;"
                                    class="btn btn-sm btn-success"><i class="fas fa-pencil-alt"></i></a>
                                <button data-toggle="delete" data-callback="reloadOrderPage()"
                                    data-url="{{ route('order_items.destroy', $attr) }}"
                                    style="padding: 2px 4px 2px 4px;" class="btn btn-sm btn-danger"><i
                                        class="fas fa-trash"></i></button>
                                @endif
                            </div>
                        </td>
                        <td style="width: 100px"><b>{{ bnConvert()->number($item->price) }}</b> ৳</td>
                        <td style="width: 100px">
                            <span class="mb-1"><b> {{ bnConvert()->number($item->quantity) }} </b></span>
                        </td>
                        <td style="width: 100px"><b>{{ bnConvert()->number($item->total) }}</b> ৳</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right; background-color: #f5f5f5">পণ্যের মূল্য:</td>
                    <td colspan="3" style="background: #eeeeee"><b>{{ bnConvert()->number($order->subtotal) }}</b>
                        টাকা </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right; background-color: #f5f5f5">ডেলিভারি ফী:</td>
                    <td colspan="3" style="background: #eeeeee">
                        <b>{{ bnConvert()->number($order->delivery_fee) }}</b> টাকা
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right; background-color: #f5f5f5">সর্বমোট:</td>
                    <td colspan="3" style="background: #eeeeee"><b>{{ bnConvert()->number($order->total) }}</b> টাকা
                    </td>
                </tr>

            </table>

        </div>


        <style>
            .orderTotalArea {
                background-color: #f7f7f7;
                padding: 15px;
                border: 1px solid #eeeeee;
                box-shadow: -1px -2px 18px -5px rgba(170, 170, 170, 1);

                border-radius: 5px;
            }

            .orderTotalTable {
                width: 100%;
                margin: 0;
                padding: 0;
                text-align: right;
                font-size: 14px;
            }

            .orderSummeryTable td {
                min-width: 50px;
            }

            .orderSummeryTable {
                font-family: 'SolaimanLipi', Arial, sans-serif;
                text-align: justify;
                box-sizing: border-box;
            }

            .orderSummeryTableTotalTr {
                text-align: right;
            }

            .totalMessageArea {
                border: 1px solid #dddddd;
                background: #eeeeee;
                text-align: center;
                margin-top: 15px;
                font-size: 14px;
                border-radius: 5px;
                padding: 10px 5px 10px 5px;

            }
        </style>
        <div class="orderMobileVersion">

            <table class="table table-borderless orderSummeryTable">
                @foreach ($items as $key => $item)
                    @php
                        $product = $item->product;
                        $attr = array_merge(
                            request()
                                ->route()
                                ->parameters(),
                            ['order_item' => $item->uuid],
                        );
                    @endphp
                    <tr class="cartTr">
                        <style>
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
                        </style>
                        <td class="align-middle" style="padding: 5px">
                            <img src="{{ $item->product->image }}" height="70px" width="70px" alt="">
                        </td>
                        <td class="align-middle" style="text-align: left">
                            <div class="" style="font-size: 13px;font-weight: bold">
                                {{ $item->name }}
                            </div>
                            <div style="font-size: 11px;font-weight: bold; color: #767575">৳
                                {{ convertBanglaNumber($item->price) }}
                                / {{ bnConvert()->number($item->unit_quantity, false) }}
                                {{ bnConvert()->unit($item->unit) }} </div>
                            <div style="margin-top: 5px; font-size: 12px; font-weight: bold;">
                                <span
                                    style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 2px; border-radius: 5px">
                                    <span
                                        style="margin-left: 5px; margin-right: 5px;">{{ bnConvert()->number($item->quantity) }}</span>
                                </span>
                                @if ($order->isEditable())
                                <a data-toggle="modal" data-modal-header="Update Order Item #{{ $key + 1 }}"
                                    href="{{ route('order_items.edit', $attr) }}" style="padding: 2px 4px 2px 4px;"
                                    class="btn btn-sm btn-success ml-1"><i class="fas fa-pencil-alt"></i></a>
                                <button data-toggle="delete" data-callback="reloadOrderPage()"
                                    data-url="{{ route('order_items.destroy', $attr) }}"
                                    style="padding: 2px 4px 2px 4px;" class="btn btn-sm btn-danger"><i
                                        class="fas fa-trash"></i></button>
                                @endif
                            </div>
                        </td>
                        <td class="align-middle" style="text-align: center; width: 20px;">
                            <span class="badge badge-info" style="min-width: 40px">৳
                                {{ bnConvert()->number($item->total) }}</span>
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class="orderTotalArea">
                <table class="orderTotalTable">
                    <tr class="orderSummeryTableTotalTr">
                        <td colspan="2"><span>পণ্যের মূল্য:</span>
                        </td>
                        <td>৳ <b>{{ bnConvert()->number($order->subtotal) }}</b></td>
                    </tr>
                    <tr class="orderSummeryTableTotalTr">
                        <td colspan="2">ডেলিভারি ফী:</td>
                        <td>৳ <b>{{ bnConvert()->number($order->delivery_fee) }}</b></td>
                    </tr>

                    <tr class="orderSummeryTableTotalTr">
                        <td colspan="2"><span class="badge" style="font-size: 14px">সর্বমোট:</span></td>
                        <td>৳ <b>{{ bnConvert()->number($order->total) }}</b></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        function reloadOrderPage() {
            location.reload()
        }

        function updateOrderItem(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    'callback': function() {
                        reloadOrderPage();
                    }
                }
            });
        }

        function updateCustomerInfo(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    'callback': function() {
                        reloadOrderPage();
                    }
                }
            });
        }


        function updateOrderItemPrice() {

            let quantiy = $("#quantity").val();
            let price = $("#price").val();
            let wholesale_price = $("#wholesale_price").val();

            let total = quantiy * price;
            let wholesalePriceTotal = quantiy * wholesale_price;

            let profit = (total - wholesalePriceTotal);

            $("#total").val(total);
            $("#wholesale_price_total").val(wholesalePriceTotal);
            $("#profit").val(profit);

        }

        function selectProduct(){
            let productId = $("#selectProduct").val();
            if(productId == ""){
                $("#orderItemForm").html("");
                return;
            }
            $.get("{{route('orders.order_items.create_form', request()->route()->parameters())}}",{product_id: productId}, function(response, status){
                $("#orderItemForm").html(response);
            });
        }
    </script>
@endpush

