@php
    $items = $order->items;
@endphp

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

<table class="table table-borderless orderSummeryTable">
    @foreach ($items as $item)
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
            <td class="align-middle">
                <div class="" style="font-size: 13px;font-weight: bold">
                    {{ $item->name }}
                </div>
                <div style="font-size: 11px;font-weight: bold; color: #767575">৳ {{ convertBanglaNumber($item->price) }}
                    / {{ bnConvert()->number($item->unit_quantity, false) }} {{ bnConvert()->unit($item->unit) }} </div>
                <div style="margin-top: 5px; font-size: 12px; font-weight: bold;">
                    <span style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 2px; border-radius: 5px">
                        <span
                            style="margin-left: 5px; margin-right: 5px;">{{ bnConvert()->number($item->quantity) }}</span>
                    </span>
                </div>
            </td>
            <td class="align-middle" style="text-align: center; width: 20px;">
                <span class="badge badge-info" style="min-width: 40px">৳ {{ bnConvert()->number($item->total) }}</span>
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

    <div class="totalMessageArea">
        ডেলিভারি এর সময় <span class="badge badge-success"
            style="font-size: 14px">{{ bnConvert()->number($order->total) }}</span> টাকা পরিশোধ করতে হবে
    </div>
</div>
