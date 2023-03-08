<table class="table table-bordered" style="text-align: center">
    <thead>
        <tr>
            <th scope="col">অর্ডার নম্বর</th>
            <th scope="col">সর্বমোট</th>
            <th scope="col">অর্ডারটি করা হয়েছে</th>
        </tr>
    </thead>
    <tbody>
        @php
            $orderVendors = $vendorPayment->orders;
        @endphp
        @foreach ($orderVendors as $orderVendor)
            <tr>
                <th scope="row">{{ bnConvert()->number($orderVendor->order_id) }}</th>
                <td><b>{{ bnConvert()->number($orderVendor->wholesale_total) }}</b> টাকা</td>
                <td><span
                        title='{{ $orderVendor->order->created_at }}'>{{ bnConvert()->date($orderVendor->order->created_at->diffForHumans()) }}</span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div>
    <style>
        .paymentShowTd {
            width: 180px;
            text-align: right;
            background: #f5f5f5;
        }
    </style>
    <table class="table table-bordered" style="font-size: 14px;">
        <tr>
            <td class="paymentShowTd">পেমেন্ট আইডি:</td>
            <td>{{ bnConvert()->number($vendorPayment->id) }}</td>
        </tr>
        <tr>
            <td class="paymentShowTd">বিক্রেতা:</td>
            <td><span class="badge"
                    style="color: #ffffff; background-color: {{ $vendorPayment->vendor->color }}">{{ $vendorPayment->vendor->name }}</span>
            </td>
        </tr>
        <tr>
            <td class="paymentShowTd">সর্বমোট:</td>
            <td><b>{{ bnConvert()->number($vendorPayment->total) }}</b> টাকা</td>
        </tr>
        <tr>
            <td class="paymentShowTd">স্টেটাস:</td>
            <td>
                @if ($vendorPayment->is_vendor_received)
                    <span class="badge badge-success">গ্রহণ করা হয়েছে</span>
                @else
                    <span class="badge badge-warning">পেন্ডিং আছে</span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="paymentShowTd">নোট:</td>
            <td>{{ $vendorPayment->notes }}</td>
        </tr>
        <tr>
            <td class="paymentShowTd">পেমেন্টটি পাঠিয়েছে:</td>
            <td><span class="badge badge-secondary">{{ $vendorPayment->user->name }}</span></td>
        </tr>
        <tr>
            <td class="paymentShowTd">পেমেন্টটি পাঠানো হয়েছে:</td>
            <td><span class=""><span
                        title="{{ $vendorPayment->created_at->format('d M Y H:i:s') }}">{{ $vendorPayment->created_at->diffForHumans() }}</span></span>
            </td>
        </tr>
    </table>
</div>
@if (!$vendorPayment->is_vendor_received)
    <div class="float-right">
        <button data-toggle="confirm" data-title="আপনি কি নিশ্চিত?" data-subtitle="পেমেন্টটি গ্রহণ করতে চান?"  data-button-text="হ্যা, গ্রহণ করতে চাই!"
        data-cancel-button-text="বন্ধ করুন" data-url="{{route('vendor_payments.payment_confirm',  $vendorPayment)}}" class="btn btn-success btn-lg"><i class="fa fa-check"></i> পেমেন্টটি গ্রহণ করুন</button>
    </div>
@endif
