@php
    $items = $order->items();
    $orderTotal = $order->total;
    
    if (
        auth()
            ->user()
            ->isVendor()
    ) {
        $items->where(['vendor_id' => auth()->user()->id])->where(['vendor_id' => auth()->user()->id]);
        $vendor = $order
            ->vendors()
            ->where(['vendor_id' => auth()->user()->id])
            ->first();
        $orderTotal = $vendor->wholesale_total;
    }
    
    $items = $items->orderBy('vendor_id', 'desc')->get();
    
@endphp

<div style="display: none">
    @if (auth()->user()->isAdmin())
        <textarea name="" id="" cols="30" rows="10">
{{ $order->id }}
{{ $order->name }}
{{ $order->address }}
{{ $order->phone }}
----------
@foreach ($items as $item)
-[{{ $item->name }}-{{ $item->vendor ? $item->vendor->name : '' }} - {{ bnConvert()->number($item->unit_quantity, false) }} {{ bnConvert()->unit($item->unit) }} - {{ bnConvert()->number($item->price) }} -  {{ bnConvert()->number($item->quantity) }} - {{ bnConvert()->number($item->total) }}]
@endforeach

পণ্যের মূল্য:{{ bnConvert()->number($order->subtotal) }}
ডেলিভারি ফী:{{ bnConvert()->number($order->delivery_fee) }}
সর্বমোট: {{ bnConvert()->number($orderTotal) }}

</textarea>
</div>
@endif

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
        @can('order.items.add')
            <div class="float-right">
                @if ($order->isEditable())
                    <a data-toggle="modal" data-modal-size="600" data-modal-header="Add New Product"
                        href="{{ route('orders.order_items.temp_create_form',request()->route()->parameters()) }}"
                        class="btn btn-success mb-2"><i class="fas fa-plus"></i> Temporary Add Product</a>
                    <a data-toggle="modal" data-modal-size="600" data-modal-header="Add New Product"
                        href="{{ route('order_items.create',request()->route()->parameters()) }}"
                        class="btn btn-success mb-2"><i class="fas fa-plus"></i> Add Product</a>
                @endif
            </div>
        @endcan
        <div class="orderPcVersion">
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>পণ্যের ছবি</th>
                    <th style="text-align: left">পণ্য</th>
                    @can('order.items.profit_column')
                        <th>লাভ</th>
                    @endcan
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
                        $price = auth()
                            ->user()
                            ->isVendor()
                            ? $item->wholesale_price
                            : $item->price;
                        $total = auth()
                            ->user()
                            ->isVendor()
                            ? $item->wholesale_price_total
                            : $item->total;
                        
                    @endphp
                    {{-- @if ($order->is_vendor_assign &&
    $needVendorAdd &&
    auth()->user()->isAdmin())
                    <tr style="background: {{$item->vendor->color}}; color: #ffffff; ">
                        <td style="text-align: left"colspan="6">{{$item->vendor->name}}</td>
                      </tr>  
                    @endif --}}
                    <tr>
                        <td style="width: 30px">{{ bnConvert()->number($key + 1) }}</td>
                        <td style="width: 80px">
                            <img src="{{ $item->product ? $item->product->image : asset('images/default.png') }}"
                                height="70px" width="70px" alt="">
                        </td>
                        <td style="text-align: left">
                            <div class="" style="font-size: 13px;font-weight: bold">
                                @if ($item->product)
                                    <a data-toggle="modal" data-modal-size="md"
                                        data-modal-header="Product #{{ $item->product_id }}"
                                        href="{{ route('products.show', ['product' => $item->product_id]) }}">
                                @endif
                                {{ $item->name }}
                                @if ($item->product)
                                    </a>
                                @endif
                            </div>
                            <div style="font-size: 11px;font-weight: bold; color: #574b4b">
                                {{ bnConvert()->number($item->unit_quantity, false) }}
                                {{ bnConvert()->unit($item->unit) }}
                                <br />
                                <span style="color: #767575;">
                                    {{ bnConvert()->number($item->unit_quantity, false) }}
                                    {{ bnConvert()->unit($item->unit) }} ×
                                    {{ bnConvert()->floatNumber($item->quantity) }} =
                                    {{ bnConvert()->number($item->unit_quantity * $item->quantity, false) }}
                                    {{ bnConvert()->unit($item->unit) }}
                                </span>

                                @if (
                                    $item->vendor &&
                                        auth()->user()->can('order.items.vendor_name'))
                                    <br /> <span class="badge"
                                        style="background-color: {{ $item->vendor->color }}; color: #ffffff">{{ $item->vendor->name }}</span>
                                @endif
                            </div>
                            @can('order.items.edit')
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
                            @endcan
                        </td>
                        @can('order.items.profit_column')
                            <td style="width: 100px"><b>{{ bnConvert()->number($item->profit) }}</b> ৳</td>
                        @endcan
                        <td style="width: 100px"><b>{{ bnConvert()->number($price) }}</b> ৳</td>
                        <td style="width: 100px">
                            <span class="mb-1"><b> {{ bnConvert()->floatNumber($item->quantity) }} </b></span>
                        </td>
                        <td style="width: 100px"><b>{{ bnConvert()->number($total) }}</b> ৳</td>
                    </tr>
                @endforeach
                @if (!auth()->user()->isVendor())
                    <tr>
                        <td colspan="3" style="text-align: right; background-color: #f5f5f5">পণ্যের মূল্য:</td>
                        <td colspan="{{ auth()->user()->can('order.items.profit_column')? 4: 3 }}"
                            style="background: #eeeeee">
                            <b>{{ bnConvert()->number($order->subtotal) }}</b>
                            টাকা
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right; background-color: #f5f5f5">ডেলিভারি ফী:</td>
                        <td colspan="{{ auth()->user()->can('order.items.profit_column')? 4: 3 }}"
                            style="background: #eeeeee">
                            <b>{{ bnConvert()->number($order->delivery_fee) }}</b> টাকা
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" style="text-align: right; background-color: #f5f5f5">সর্বমোট:</td>
                    <td colspan="{{ auth()->user()->can('order.items.profit_column')? 4: 3 }}"
                        style="background: #eeeeee">
                        <b>{{ bnConvert()->number($orderTotal) }}</b> টাকা
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
                        $price = auth()
                            ->user()
                            ->isVendor()
                            ? $item->wholesale_price
                            : $item->price;
                        $total = auth()
                            ->user()
                            ->isVendor()
                            ? $item->wholesale_price_total
                            : $item->total;
                        if (
                            auth()
                                ->user()
                                ->isVendor() &&
                            $item->vendor_id != auth()->user()->id
                        ) {
                            continue;
                        }
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
                            <img src="{{ $item->product ? $item->product->image : asset('images/default.png') }}"
                                height="70px" width="70px" alt="">
                        </td>
                        <td class="align-middle" style="text-align: left">
                            <div class="" style="font-size: 13px;font-weight: bold">
                                {{ $item->name }}
                                @if (
                                    $item->vendor &&
                                        auth()->user()->can('order.items.vendor_name'))
                                    <br /> <span class="badge"
                                        style="background-color: {{ $item->vendor->color }}; color: #ffffff">{{ $item->vendor->name }}</span>
                                @endif
                            </div>
                            <div style="font-size: 11px;font-weight: bold; color: #767575">
                                ৳
                                {{ convertBanglaNumber($price) }}
                                / {{ bnConvert()->number($item->unit_quantity, false) }}
                                {{ bnConvert()->unit($item->unit) }} <br />
                                <span style="color: #767575; border-top: 1px solid #aaaaaa">
                                    {{ bnConvert()->number($item->unit_quantity, false) }}
                                    {{ bnConvert()->unit($item->unit) }} ×
                                    {{ bnConvert()->floatNumber($item->quantity) }} =
                                    {{ bnConvert()->number($item->unit_quantity * $item->quantity, false) }}
                                    {{ bnConvert()->unit($item->unit) }}
                                </span>

                            </div>
                            <div style="margin-top: 3px; font-size: 12px;">
                                <span
                                    style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 2px 0px 2px 0px; border-radius: 5px; ">
                                    <span style="margin-left: 2px; margin-right: 5px;">পরিমান:
                                        <b>{{ bnConvert()->floatNumber($item->quantity) }}</b></span>
                                </span>
                                @can('order.items.edit')
                                    @if ($order->isEditable())
                                        <a data-toggle="modal" data-modal-header="Update Order Item #{{ $key + 1 }}"
                                            href="{{ route('order_items.edit', $attr) }}"
                                            style="padding: 2px 4px 2px 4px;font-size: 10px;"
                                            class="btn btn-sm btn-success ml-1"><i class="fas fa-pencil-alt"></i></a>
                                        <button data-toggle="delete" data-callback="reloadOrderPage()"
                                            data-url="{{ route('order_items.destroy', $attr) }}"
                                            style="padding: 2px 4px 2px 4px; font-size: 10px;"
                                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    @endif
                                @endcan
                            </div>
                        </td>
                        <td class="align-middle" style="text-align: center; width: 20px;">
                            <span class="badge badge-info" style="min-width: 40px">৳
                                {{ bnConvert()->number($total) }}</span>
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class="orderTotalArea">
                <table class="orderTotalTable">
                    @if (!auth()->user()->isVendor())
                        <tr class="orderSummeryTableTotalTr">
                            <td colspan="2"><span>পণ্যের মূল্য:</span>
                            </td>
                            <td>৳ <b>{{ bnConvert()->number($order->subtotal) }}</b></td>
                        </tr>
                        <tr class="orderSummeryTableTotalTr">
                            <td colspan="2">ডেলিভারি ফী:</td>
                            <td>৳ <b>{{ bnConvert()->number($order->delivery_fee) }}</b></td>
                        </tr>
                    @endif
                    <tr class="orderSummeryTableTotalTr">
                        <td colspan="2"><span class="badge" style="font-size: 14px">সর্বমোট:</span></td>
                        <td>৳ <b>{{ bnConvert()->number($orderTotal) }}</b></td>
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

            let total = Math.round(quantiy * price);
            let wholesalePriceTotal = Math.round(quantiy * wholesale_price);

            let profit = (total - wholesalePriceTotal);

            $("#total").val(total);
            $("#wholesale_price_total").val(wholesalePriceTotal);
            $("#profit").val(profit);

        }

        function selectProduct() {
            let productId = $("#selectProduct").val();
            if (productId == "") {
                $("#orderItemForm").html("");
                return;
            }
            $.get("{{ route('orders.order_items.create_form',request()->route()->parameters()) }}", {
                product_id: productId
            }, function(response, status) {
                $("#orderItemForm").html(response);
            });
        }
    </script>
@endpush
