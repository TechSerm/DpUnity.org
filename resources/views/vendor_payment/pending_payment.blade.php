<form action="{{ route('vendor_payments.store', ['vendor_id' => request()->vendor_id]) }}" method="post">
    @csrf
    <table class="table table-bordered" style="text-align: center">
        <thead>
            <tr>
                <th scope="col">অর্ডার নম্বর</th>
                <th scope="col">সর্বমোট</th>
                <th scope="col">পেমেন্ট আইডি</th>
                <th scope="col">অর্ডারটি করা হয়েছে</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendor['send_ids'] as $order)
                <tr>
                    <th scope="row"><a href="{{route('vendor_payments.show_order', ['vendor_id' => request()->vendor_id,'order_id' => $order['uuid']])}}" data-modal-header="Order {{$order['order_id']}}" data-toggle="modal">{{ bnConvert()->number($order['order_id']) }}</a></th>
                    <td><b>{{ bnConvert()->number($order['total']) }}</b> টাকা</td>
                    <td><b>{{ bnConvert()->number($order['payment_id']) }}</b></td>
                    <td>
                        <span title='{{ $order['date'] }}'>{{ bnConvert()->date($order['date']->diffForHumans()) }}</span>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <x-adminlte-small-box
        title="{{ bnConvert()->number($vendor['send']) }} টাকা ({{ bnConvert()->number(count($vendor['send_ids'])) }})"
        text="বিক্রেতাকে পাঠানো হয়েছে" icon="fas fa-clock" theme="warning" />

</form>
