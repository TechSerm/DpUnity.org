<table class="table table-bordered" style="text-align: center">
    <thead>
        <tr>
            <th scope="col">অর্ডার নম্বর</th>
            <th scope="col">পণ্যে লাভ</th>
            <th scope="col">ডেলিভারি ফি</th>
            <th scope="col">সর্বমোট</th>
            <th scope="col">অর্ডারটি করা হয়েছে</th>
        </tr>
    </thead>
    <tbody>
        @php
            $orders = $diposite->orders;
        @endphp
        @foreach ($orders as $order)
            <tr>
                <th scope="row">{{ bnConvert()->number($order->id) }}</th>
                <td>{{ bnConvert()->number($order->products_profit) }} টাকা</td>
                <td>{{ bnConvert()->number($order->delivery_fee) }} টাকা</td>
                <td><b>{{ bnConvert()->number($order->total_profit) }}</b> টাকা</td>
                <td><span
                        title='{{ $order->created_at }}'>{{ bnConvert()->date($order->created_at->diffForHumans()) }}</span>
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
            <td>{{ bnConvert()->number($diposite->id) }}</td>
        </tr>
        <tr>
            <td class="paymentShowTd">পণ্যের লাভ:</td>
            <td><b>{{ bnConvert()->number($diposite->product_profit) }}</b> টাকা</td>
        </tr>
        <tr>
            <td class="paymentShowTd">ডেলিভারি ফি:</td>
            <td><b>{{ bnConvert()->number($diposite->delivery_fee) }}</b> টাকা</td>
        </tr>
        <tr>
            <td class="paymentShowTd">মোট লাভ:</td>
            <td><b>{{ bnConvert()->number($diposite->total_amount) }}</b> টাকা</td>
        </tr>
        <tr>
            <td class="paymentShowTd">সর্বমোট অর্ডার:</td>
            <td><b>{{ bnConvert()->number($diposite->total_orders) }}</b> টাকা</td>
        </tr>
        <tr>
            <td class="paymentShowTd">স্টেটাস:</td>
            <td>
                @if ($diposite->is_approved)
                    <span class="badge badge-success">গ্রহণ করা হয়েছে</span>
                @else
                    <span class="badge badge-warning">পেন্ডিং আছে</span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="paymentShowTd">নোট:</td>
            <td>{{ $diposite->note }}</td>
        </tr>
        <tr>
            <td class="paymentShowTd">পেমেন্টটি জমা দিয়েছে:</td>
            <td><span class="badge badge-secondary">{{ $diposite->user->name }}</span></td>
        </tr>
        <tr>
            <td class="paymentShowTd">পেমেন্টটি জমা হয়েছে	:</td>
            <td><span class=""><span
                        title="{{ $diposite->created_at->format('d M Y H:i:s') }}">{{ $diposite->created_at->diffForHumans() }}</span></span>
            </td>
        </tr>
    </table>
</div>
@if (!$diposite->is_approved)
    <div class="float-right">
        <button data-toggle="confirm" data-title="আপনি কি নিশ্চিত?" data-subtitle="পেমেন্টটি গ্রহণ করতে চান?"
            data-button-text="হ্যা, গ্রহণ করতে চাই!" data-cancel-button-text="বন্ধ করুন"
            data-url="{{ route('order_profit_diposites.confirm', $diposite) }}" class="btn btn-success btn-lg"><i
                class="fa fa-check"></i> পেমেন্টটি গ্রহণ করুন</button>
    </div>
@endif
