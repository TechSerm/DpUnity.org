

<div class="orderDetails mb-3">
    <div class="header" style="background: #2980b9">
        অর্ডার তথ্য
    </div>
    <div class="body">
        <table class="table table-bordered">
            <tr>
                <td class="infoTd" style="width: 150px;">অর্ডার নাম্বার </td>
                <td style="font-weight: bold; font-size: 16px;">{{ $order->id }}</td>
            </tr>
            <tr>
                <td>অর্ডারটি করা হয়েছে</td>
                <td>{{ bnConvert()->date($order->created_at->format('d M Y, h:i a')) }}
                    ({{ bnConvert()->date($order->created_at->diffForHumans()) }})</td>
            </tr>
            <tr>
                <td>অর্ডারটির বর্তমান অবস্থা</td>
                <td><span class="badge" style="background: {{$order->customer_status['color']}}; color: #000000">{{$order->customer_status['name'] }}</span></td>
            </tr>
            <tr>
                <td>বিক্রেতা</td>
                <td>{{$order->vendor ? $order->vendor->name : ''}}</td>
            </tr>
            <tr>
                <td>আইপি এড্রেস</td>
                <td><span class='badge badge-primary'>{{ $order->ip_address }}<span></td>
            </tr>
            <tr>
                <td>এপ ভার্সন</td>
                <td>{!! $order->app_version ? "<span class='badge badge-success'>$order->app_version</span>" : "<span class='badge badge-warning'>Not Use Bibisena App</span><span class='ml-1 badge-secondary'>$order->user_agent<span>" !!}</td>
            </tr>
        </table>

        <div class="text-right mb-2"> 
            @if ($order->isEditable())
            <button class="btn btn-info mt-1" data-modal-title="Update Vendor" data-url="{{route('orders.vendor.update', request()->route()->parameters())}}" data-toggle="modal" >{{$order->vendor_id ? 'Update Vendor' : 'Add Vendor'}}</a>
            @endif
        </div>
    </div>

</div>

<div class="orderDetails mb-3">
    <div class="header" style="background: #d35400">
        পণ্য ডেলিভারি তথ্য
    </div>
    <div class="body">
        <table class="table table-bordered">
            <tr>
                <td class="infoTd" style="width: 150px;">নাম </td>
                <td>{{ $order->name }}</td>
            </tr>
            <tr>
                <td>বাড়ির ঠিকানা</td>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <td>মোবাইল নাম্বার</td>
                <td>{{ $order->phone }}</td>
            </tr>
        </table>

        <div class="text-right mb-2">
            @if ($order->isEditable())
            <button data-toggle="modal" data-modal-size="md" data-modal-title="Update Customer Details"
                data-url="{{ route('orders.customer.update',request()->route()->parameters()) }}" type="button"
                class="btn btn-success">Edit Customer Info</button>

            @endif
        </div>
    </div>

</div>