<table class="table table-borderless orderSummeryTable">
    @foreach ($items as $key => $item)
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
                <img src="{{ $item->product ? $item->product->image : asset('images/default.png') }}" height="70px"
                    width="70px" alt="">
            </td>
            <td class="align-middle" style="text-align: left">
                <div class="" style="font-size: 13px;font-weight: bold">
                    {{ $item->name }}
                </div>
                <div style="font-size: 11px;font-weight: bold; color: #767575">
                    ৳
                    {{ convertBanglaNumber($item->wholesale_price) }}
                    / {{ bnConvert()->number($item->unit_quantity, false) }}
                    {{ bnConvert()->unit($item->unit) }} </div>
                <div style="margin-top: 3px; font-size: 12px;">
                    <span
                        style="background: #f5f5f5; border: 1px solid #aaaaaa; padding: 2px 0px 2px 0px; border-radius: 5px; ">
                        <span style="margin-left: 2px; margin-right: 5px;">পরিমান:
                            <b>{{ bnConvert()->number($item->quantity) }}</b></span>
                    </span>
                </div>
            </td>
            <td class="align-middle" style="text-align: center; width: 20px;">
                <span class="badge badge-info" style="min-width: 40px">৳
                    {{ bnConvert()->number($item->wholesale_price_total) }}</span>
            </td>
        </tr>
    @endforeach
</table>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <x-adminlte-small-box title="{{ bnConvert()->number($orderVendor->wholesale_total) }} টাকা ({{bnConvert()->number(count($items))}} টি পণ্য)" text="সর্বমোট পাইকারি মূল্য"
            icon="fa fa-credit-card" theme="success" />
    </div>
</div>
