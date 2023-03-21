<div class="table-responsive">
    <table class="table table-bordered" style="text-align: center; font-size: 14px">
        <thead>
            <tr>
                <th scope="col">আইডি</th>
                <th scope="col">পণ্যের লাভ</th>
                <th scope="col">ডেলিভারি ফি</th>
                <th scope="col">মোট লাভ</th>
                <th scope="col">সর্বমোট অর্ডার</th>
                <th scope="col">স্টেটাস</th>
                <th scope="col">নোট</th>
                <th scope="col">পেমেন্টটি জমা দিয়েছে</th>
                <th scope="col">পেমেন্টটি জমা হয়েছে</th>
                <th scope="col"></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($diposites as $diposite)
                <tr>
                    <td>{{ $diposite->id }}</td>
                    <td>{{ bnConvert()->number($diposite->product_profit) }}</b> টাকা</td>
                    <td>{{ bnConvert()->number($diposite->delivery_fee) }}</b> টাকা</td>
                    <td><b>{{ bnConvert()->number($diposite->total_amount) }}</b> টাকা</td>
                    <td>{{ bnConvert()->number($diposite->total_orders) }}</td>
                    <td>
                        @if ($diposite->is_approved)
                            <span class="badge badge-success">গ্রহণ করা হয়েছে</span>
                        @else
                            <span class="badge badge-warning">পেন্ডিং আছে</span>
                        @endif
                    </td>
                    <td>{{ $diposite->note }}</td>
                    <td><span class="badge badge-secondary">{{ $diposite->user->name }}</span></td>
                    <td><span
                            title="{{ $diposite->created_at->format('d M Y H:i:s') }}">{{ bnConvert()->date($diposite->created_at->diffForHumans()) }}</span>
                    </td>
                    <td>
                         <a href="{{ route('order_profit_diposites.show', $diposite) }}" data-modal-size="md"
                            class="btn btn-success btn-sm"
                            data-modal-header="পেমেন্ট #{{ bnConvert()->number($diposite->id) }}"
                            data-toggle="modal"><i class="fa fa-eye"></i></a>
                        @if (
                            !$diposite->is_approved &&
                                auth()->user()->isAdmin())
                            <button data-toggle="delete" data-callback='location.reload()'
                                data-url="{{ route('order_profit_diposites.destroy', $diposite) }}"
                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        @endif 

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <div style="text-align: center">
        {{ $diposites->links() }}
    </div>
</div>
