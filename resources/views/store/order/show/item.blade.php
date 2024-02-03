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
        <img src="{{ $item->product ? $item->product->image : asset('images/default.png') }}" height="70px" width="70px" alt="">
    </td>
    <td class="align-middle">
        <div class="" style="font-size: 13px;font-weight: bold">
            <a href="{{ route('store.product', ['product_id', $item->product_id]) }}"> {{ $item->name }}</a>
        </div>
        <div style="font-size: 11px;font-weight: bold; color: #767575">৳ {{ convertBanglaNumber($item->price) }}
             </div>
        <div style="margin-top: 5px; font-size: 12px; font-weight: bold;">
            <span style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 2px; border-radius: 5px">
                <span
                    style="margin-left: 5px; margin-right: 5px;">{{ bnConvert()->floatNumber($item->quantity) }}</span>
            </span>
        </div>
    </td>
    <td class="align-middle" style="text-align: center; width: 20px;">
        <span class="badge badge-info" style="min-width: 40px">৳ {{ bnConvert()->number($item->total) }}</span>
    </td>
</tr>