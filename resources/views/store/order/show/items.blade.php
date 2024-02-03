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
        <tr style="" class="cartTr">
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
                    font-size: 16px;
                }

                .tdTitle {
                    width: 65%;
                }

                .orderTotalTable td {
                    border: 1px solid #eeeeee;
                    padding: 10px;
                }

                .orderShowProductLink {
                    color: #000000;
                }
                .orderShowProductLink:hover {
                    text-decoration: none;
                }
            </style>
            <td class="align-middle" style="padding: 10px; width: 110px;">
                <img src="{{ $item->product ? $item->product->image : asset('images/default.png') }}"
                    class="img-thumbnail" height="100px" width="100px" alt="">
            </td>
            <td class="">
                <div class="" style="font-size: 15px;font-weight: bold">
                    <a class="orderShowProductLink"
                        href="{{ route('store.product.show', ['product' => $item->product_id]) }}">{{ $item->name }}</a>
                </div>
                <div style="font-size: 13px;font-weight: bold; color: #767575; margin-top: 0px">৳
                    {{ convertBanglaNumber($item->price) }} </div>
                <div style="margin-top: 10px; font-size: 14px; font-weight: bold;">
                    <span
                        style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 3px 2px 5px 2px; border-radius: 5px">
                        <span
                            style="margin-left: 5px; margin-right: 5px;">{{ convertBanglaNumber($item->quantity) }}</span>

                    </span>
                </div>
            </td>
            <td class="align-middle" style="text-align: center; width: 20px;">
                <span class="badge badge-info" style="min-width: 40px; font-size: 13px;">৳
                    {{ bnConvert()->number($item->total) }}</span>
            </td>
        </tr>
    @endforeach
</table>
