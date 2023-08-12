<div class="orderDetails mb-3">
    <style>
        .infoTd {
            text-align: right !important;
            background: #f5f5f5;
        }
    </style>
    <div class="header" style="background: #2980b9">
        অর্ডার তথ্য
    </div>
    <div class="body">
        <table class="table table-bordered">
            <tr>
                <td class="infoTd" style="width: 150px;">অর্ডার নাম্বার </td>
                <td style="font-weight: bold; font-size: 16px;">{{ $order->id }}</td>
            </tr>
            @can('order.info.order_date')
                <tr>
                    <td class="infoTd">অর্ডারটি করা হয়েছে</td>
                    <td>{{ bnConvert()->date($order->created_at->format('d M Y, h:i a')) }}
                        ({{ bnConvert()->date($order->created_at->diffForHumans()) }})</td>
                </tr>
            @endcan

            <tr>
                <td class="infoTd">অর্ডারটির বর্তমান অবস্থা</td>
                <td><span class="badge"
                        style="background: {{ $order->customer_status['color'] }}; color: #000000">{{ $order->customer_status['name'] }}</span>
                </td>
            </tr>
            @can('order.info.total_profit')
                <tr>
                    <td class="infoTd">ক্যাশে জমা দিতে হবে</td>
                    <td> <b>({{ bnConvert()->number($order->delivery_fee) }} টাকা + {{ bnConvert()->number($order->products_profit) }}  টাকা) = {{ bnConvert()->number($order->total_profit) }}</b> টাকা</td>
                </tr>
            @endcan
            @can('order.info.wholesale_total')
                <tr>
                    <td class="infoTd">বিক্রেতাকে দিতে হবে</td>
                    <td> <b>{{ bnConvert()->number($order->wholesale_total) }}</b> টাকা</td>
                </tr>
            @endcan
        </table>

        <div class="text-right mb-2">
            @can('order.info.history')
                <a class="btn btn-info" href="{{ route('invoice.print', ['order' => $order]) }}">Print Invoice</a>
                <button class="btn btn-primary" data-modal-title="Order Log" data-toggle="modal" data-modal-size="lg"
                    data-url="{{ route('orders.show.history',request()->route()->parameters()) }}">Log History</button>
            @endcan
            @can('order.info.cancel_order')
                @if ($order->isEditable())
                    <button class="btn btn-danger"
                        data-url="{{ route('orders.status.change', ['order' => $order->id, 'status' => 'canceled']) }}"
                        data-toggle="confirm" data-title="আপনি কি নিশ্চিত?" data-subtitle="অর্ডারটি আপনি কি বাতিল করতে চান?"
                        data-button-text="হ্যা, আমি বাতিল করতে চাই!" data-cancel-button-text="বন্ধ করুন">অর্ডারটি বাতিল
                        করুন!</button>
                @endif
            @endcan
        </div>

    </div>

</div>

@can('order.customer_area')
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
                    <td class="infoTd">বাড়ির ঠিকানা</td>
                    <td>{{ $order->address }}</td>
                </tr>
                @can('order.customer_area.phone_number')
                    <tr>
                        <td class="infoTd">মোবাইল নাম্বার</td>
                        <td>{{ $order->phone }}</td>
                    </tr>
                @endcan
            </table>
            @can('order.customer_area.edit_info')
                <div class="text-right mb-2">
                    @if ($order->isEditable())
                        <button data-toggle="modal" data-modal-size="md" data-modal-title="Update Customer Details"
                            data-url="{{ route('orders.customer.update',request()->route()->parameters()) }}" type="button"
                            class="btn btn-success">Edit Customer Info</button>
                    @endif
                </div>
            @endcan

        </div>

    </div>
@endcan
