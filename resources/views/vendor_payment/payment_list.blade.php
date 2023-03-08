<div class="table-responsive">
    <table class="table table-bordered" style="text-align: center; font-size: 14px">
        <thead>
            <tr>
                <th scope="col">পেমেন্ট আইডি</th>
                <th scope="col">বিক্রেতা</th>
                <th scope="col">সর্বমোট</th>
                <th scope="col">সর্বমোট অর্ডার</th>
                <th scope="col">স্টেটাস</th>
                <th scope="col">নোট</th>
                <th scope="col">পেমেন্টটি পাঠিয়েছে</th>
                <th scope="col">পেমেন্টটি পাঠানো হয়েছে</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendorPayments as $vendorPayment)
                <tr>
                    <td>{{ $vendorPayment->id }}</td>
                    <td>
                        <span class="badge"
                            style="color: #ffffff; background-color: {{ $vendorPayment->vendor->color }}">{{ $vendorPayment->vendor->name }}</span>

                    </td>
                    <td><b>{{ bnConvert()->number($vendorPayment->total) }}</b> টাকা</td>
                    <td>{{ $vendorPayment->total_orders }}</td>
                    <td>
                        @if ($vendorPayment->is_vendor_received)
                            <span class="badge badge-success">গ্রহণ করা হয়েছে</span>
                        @else
                            <span class="badge badge-warning">পেন্ডিং আছে</span>
                        @endif
                    </td>
                    
                    <td>{{ $vendorPayment->notes }}</td>
                    <td>{{ $vendorPayment->user->name }}</td>
                    <td><span
                            title="{{ $vendorPayment->created_at->format('d M Y H:i:s') }}">{{ $vendorPayment->created_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <a href="{{ route('vendor_payments.show', $vendorPayment) }}" data-modal-size="md"
                            class="btn btn-success btn-sm"
                            data-modal-header="পেমেন্ট #{{ bnConvert()->number($vendorPayment->id) }}"
                            data-toggle="modal"><i class="fa fa-eye"></i></a>
                        @if (
                            !$vendorPayment->is_vendor_received &&
                                auth()->user()->isAdmin())
                            <button data-toggle="delete" data-callback='location.reload()'
                                data-url="{{ route('vendor_payments.destroy', $vendorPayment) }}"
                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        @endif

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <div style="text-align: center">
        {{ $vendorPayments->links() }}
    </div>
</div>
