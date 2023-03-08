@php
    $vendors = $order->vendors()->orderBy('wholesale_total','desc')->get();
@endphp

<div class="orderDetails mb-3">
    <div class="header" style="background: #5f27cd">
        বিক্রেতার তথ্য
    </div>
    <div class="body">

        <div class="row">
            @foreach ($vendors as $vendor)
                @php
                    if (auth()->user()->isVendor() && $vendor->vendor_id != auth()->user()->id) {
                        continue;
                    }
                    $vendorPaymentMessage = "";
                    $vendorBoxColor = "";
                    $vendorBoxIcon = "";
                    if ($vendor->is_vendor_payment_complete) {
                        $vendorPaymentMessage = "বিক্রেতা টাকা পেয়েছে।";
                        $vendorBoxColor = "success";
                        $vendorBoxIcon = "fa-check";
                    } elseif ($vendor->is_vendor_payment_send) {
                        $vendorPaymentMessage = "বিক্রেতার টাকা পাঠানো হয়েছে।";
                        $vendorBoxColor = "warning";
                        $vendorBoxIcon = "fa-clock";
                    } else {
                        $vendorPaymentMessage = "বিক্রেতার টাকা বাকি আছে।";
                        $vendorBoxColor = "danger";
                        $vendorBoxIcon = "fa-times";
                    }

                    if(!$order->is_delivery_complete){
                        $vendorBoxColor = "secondary";
                        $vendorBoxIcon = "";
                        $vendorPaymentMessage = "";
                    }
                @endphp
                <div class="col-md-4 col-sm-6">
                    <div class="info-box bg-{{$vendorBoxColor}}">
                        <span class="info-box-icon"><i class="fa {{$vendorBoxIcon}}"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number">{{ $vendor->user->name }}</span>
                            @if (auth()->user()->isAdmin())
                                <span class="">সর্বমোট: <b>{{ bnConvert()->number($vendor->total) }}</b> টাকা</span>
                            @endif
                            <span class="">সর্বমোট পাইকারি দাম:<b>
                                    {{ bnConvert()->number($vendor->wholesale_total) }}</b> টাকা</span>
                            @if (auth()->user()->isAdmin())
                            <span class="">লাভ: <b>{{ bnConvert()->number($vendor->profit) }}</b> টাকা</span>
                            <span class="">শতকরা লাভ : <b>{{ bnConvert()->floatNumber(($vendor->profit * 100)/($vendor->wholesale_total == 0 ? 1 : $vendor->wholesale_total), 1) }}</b>%</span>
                            @endif
                            <span class="info-box-number">{{$vendorPaymentMessage}}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
