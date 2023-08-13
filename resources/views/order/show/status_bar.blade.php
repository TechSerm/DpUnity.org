<div class="orderDetails mb-3">
    <div class="header" style="background: #8e44ad">
        অর্ডার অবস্থা
    </div>
    <div class="body">
        <table class="table table-bordered">
            <tr>
                <td style="text-align: right; max-width: 400px">
                    গ্রহণ করা হয়েছে
                </td>
                <td>
                    @if ($order->is_approved == false && $order->is_cancelled == false && auth()->user()->can('order.status.approved'))
                        <button class="btn btn-success" data-url="{{route('orders.status.change', ['order' => $order->id,'status' => 'approved'])}}" data-toggle="confirm" data-title="আপনি কি নিশ্চিত?"
                        data-subtitle="অর্ডারটি গ্রহণ করা হয়েছে?" data-button-text="হ্যা, আমি নিশ্চিত!"
                        data-cancel-button-text="বন্ধ করুন">হ্যা!</button>
                    @endif
                    @if ($order->is_approved)
                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                    @elseif ($order->is_cancelled)
                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: right; max-width: 400px">
                    বিক্রেতার কাছে পাঠানো হয়েছে	
                </td>
                <td>
                    @if ($order->is_vendor_assign == false && $order->is_approved == true && $order->is_cancelled == false && auth()->user()->can('order.status.assign_vendor'))
                        <button class="btn btn-success" data-url="{{route('orders.vendor.assign_product_vendor_list', request()->route()->parameters())}}" data-modal-size="md" data-toggle="modal" data-modal-title="আপনি কি নিশ্চিত?">হ্যা!</button>
                    @endif
                    @if ($order->is_vendor_assign)
                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                    @elseif ($order->is_cancelled)
                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                    @endif
                </td>
            </tr>
        @php
            $allVendorPackReady = true;
            $vendors = $order->vendors();
            if(auth()->user()->isVendor())$vendors->where(['vendor_id' => auth()->user()->id]);
            $vendors = $vendors->get();
            $orderTotal = $order->total;
            if (auth()->user()->isVendor()) {
                $orderTotal = $vendors[0]->wholesale_total;
            }
        @endphp
        @if (!auth()->user()->isCashier())
            @foreach ($vendors as $vendor)
            @php
                if (!$vendor->is_pack_complete) {
                    $allVendorPackReady = false;
                }
                if(auth()->user()->isVendor() && $vendor->vendor_id != auth()->user()->id)continue;
                
            @endphp
            <tr style="background: {{$vendor->user->color}}; color: #ffffff">
                <td style="text-align: right; max-width: 400px">
                    {{$vendor->user->name}} কর্তৃক গ্রহণ করা হয়েছে
                </td>
                <td>
                    @if ($vendor->is_received == false && $order->is_cancelled == false)
                    <button class="btn btn-success" data-url="{{route('orders.status.change', ['order' => $order->id,'status' => 'vendor_received', 'vendor' => $vendor->uuid])}}" data-toggle="confirm" data-title="আপনি কি নিশ্চিত?"
                        data-subtitle="অর্ডারটি ডেলিভারির জন্য প্রস্তুতি সম্পন্ন হয়েছে?" data-button-text="হ্যা, আমি নিশ্চিত!"
                        data-cancel-button-text="বন্ধ করুন">হ্যা!</button>
                    @endif
                    @if ($vendor->is_received)
                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                    @elseif ($order->is_cancelled)
                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                    @endif
                </td>
            </tr>
            <tr style="background: {{$vendor->user->color}}; color: #ffffff">
                <td style="text-align: right; max-width: 400px">
                    {{$vendor->user->name}} এর প্রস্তুতি সম্পন্ন হয়েছে
                </td>
                <td>
                    @if ($vendor->is_pack_complete == false && $vendor->is_received == true && $order->is_cancelled == false)
                    <button class="btn btn-success" data-url="{{route('orders.status.change', ['order' => $order->id,'status' => 'vendor_pack_complete', 'vendor' => $vendor->uuid])}}" data-toggle="confirm" data-title="আপনি কি নিশ্চিত?"
                        data-subtitle="অর্ডারটি ডেলিভারির জন্য প্রস্তুতি সম্পন্ন হয়েছে?" data-button-text="হ্যা, আমি নিশ্চিত!"
                        data-cancel-button-text="বন্ধ করুন">হ্যা!</button>
                    @endif
                    @if ($vendor->is_pack_complete)
                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                    @elseif ($order->is_cancelled)
                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                    @endif
                </td>
            </tr>
            @endforeach
            @endif

            <tr>
                <td style="text-align: right; max-width: 400px">
                    ডেলিভারির জন্য প্রস্তুতি সম্পন্ন হয়েছে
                </td>
                <td>
                    @if ($order->is_pack_complete == false && $allVendorPackReady == true && $order->is_vendor_assign == true && $order->is_cancelled == false && auth()->user()->can('order.status.pack_complete'))
                        <button class="btn btn-success" data-url="{{route('orders.status.change', ['order' => $order->id,'status' => 'pack_complete'])}}" data-toggle="confirm" data-title="আপনি কি নিশ্চিত?"
                        data-subtitle="অর্ডারটি ডেলিভারির জন্য প্রস্তুতি সম্পন্ন হয়েছে?" data-button-text="হ্যা, আমি নিশ্চিত!"
                        data-cancel-button-text="বন্ধ করুন">হ্যা!</button>
                    @endif
                    @if ($order->is_pack_complete)
                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                    @elseif ($order->is_cancelled)
                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: right; max-width: 400px">
                    ডেলিভারির জন্য রওনা হয়েছে
                </td>
                <td>
                    @if ($order->is_delivery_start == false && $order->is_pack_complete == true && $order->is_cancelled == false && auth()->user()->can('order.status.start_delivery'))
                        <button class="btn btn-success" data-url="{{route('orders.status.change', ['order' => $order->id,'status' => 'start_delivery'])}}" data-toggle="confirm" data-title="আপনি কি নিশ্চিত?"
                        data-subtitle="অর্ডারটি ডেলিভারির জন্য রওনা হয়েছে?" data-button-text="হ্যা, আমি নিশ্চিত!"
                        data-cancel-button-text="বন্ধ করুন">হ্যা!</button>
                    @endif
                    @if ($order->is_delivery_start)
                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                    @elseif ($order->is_cancelled)
                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: right; max-width: 400px">
                    ডেলিভারি টি সম্পন্ন হয়েছে
                </td>
                <td>
                    @if ($order->is_delivery_complete == false && $order->is_delivery_start == true && $order->is_cancelled == false && auth()->user()->can('order.status.complete_delivery'))
                        <button class="btn btn-success" data-url="{{route('orders.status.change', ['order' => $order->id,'status' => 'delivery_completed'])}}" data-toggle="confirm" data-title="আপনি কি নিশ্চিত?"
                        data-subtitle="অর্ডারটি ডেলিভারি টি সম্পন্ন হয়েছে?" data-button-text="হ্যা, আমি নিশ্চিত!"
                        data-cancel-button-text="বন্ধ করুন">হ্যা!</button>
                    @endif
                    @if ($order->is_delivery_complete)
                        <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                    @elseif ($order->is_cancelled)
                        <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
