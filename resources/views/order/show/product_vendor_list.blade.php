@php
    $items = $order->items;
@endphp

<form data-reset="false" data-page-reload="true"
    action="{{ route('orders.vendor.assign_product_vendor_list',request()->route()->parameters()) }}" method="post">
    @csrf
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
                    <img src="{{ $item->product ? $item->product->image : asset('images/default.png') }}" height="70px" width="70px" alt="">
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
                        <span style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 2px; border-radius: 5px">
                            <span
                                style="margin-left: 5px; margin-right: 5px;">{{ bnConvert()->number($item->quantity) }}</span>
                        </span>
                        <span class="badge-info"
                            style="border-radius: 5px;min-width: 40px; padding: 5px; margin-left: 5px; margin-right: 5px;">৳
                            {{ bnConvert()->number($item->total) }}</span>

                    </div>
                </td>
                <td class="align-middle" style="text-align: center; width: 150px;">
                    <label for="" style="font-size: 12px;">বিক্রেতা</label>
                    <select name="product_vendor[{{ $item->uuid }}]"
                        class="custom-select {{ ((!$item->product) || ($item->product && !$item->product->vendor_id)) ? 'is-invalid' : '' }}" style="padding: 2px;"
                        name="" id="">
                        <option value="">Select Vendor</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}"
                                {{ $item->product ? ($vendor->id == $item->product->vendor_id ? 'selected' : '') : '' }}>{{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
        @endforeach
    </table>


    <button class="btn btn-primary" type="submit">Assign Vendor</button>
</form>
