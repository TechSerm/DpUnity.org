<style>
    @media (max-width: 768px) {
        .mobile-area {
            display: block;
        }

        .desktop-area {
            display: none;
        }
    }

    @media (min-width: 769px) {
        .mobile-area {
            display: none;
        }

        .desktop-area {
            display: block;
        }
    }

    .mobile-block {
        padding: 5px;
        font-size: 12px;
        margin-bottom: 10px;
        border-radius: 3px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .mobile-block .td1 {
        width: 120px;
        text-align: right;
    }

    .mobile-block tr {
        line-height: 2px;
        min-height: 2px;
        height: 2px;
        color: #000000;
    }

    .borderless td,
    .borderless th {
        border: none;
    }

    .mobile-block table {
        background: #ffffff;
        margin-bottom: 0px;
        border-radius: 5px;
    }

    .mobile-block .span-block {
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 5px;
        margin-right: 2px;
        padding: 5px;
        margin-bottom: 5px;
        color: #000000;
        font-size: 12px;
    }

    .mobile-block .button-area {
        position: absolute;
        margin-top: 5px;
        margin-left: -35px;
        text-align: right;
        width: 100%;
    }

    .mobile-block .btn {
        font-size: 12px;
        height: 25px;
        width: 30px;
    }

    .mobile-block .span-badge {
        margin-top: -11px;
        margin-bottom: -13px;
    }
</style>

<div class="mobile-area">
    @foreach ($diposites as $diposite)
        <div class=" mobile-block " style="">
            <div class="button-area">
                <a href="{{ route('order_profit_diposites.show', $diposite) }}" data-modal-size="md"
                    class="btn btn-success btn-sm mb-1"
                    data-modal-header="পেমেন্ট #{{ bnConvert()->number($diposite->id) }}" data-toggle="modal"><i
                        class="fa fa-eye"></i></a><br />
                @if (
                    !$diposite->is_approved &&
                        auth()->user()->isAdmin())
                    <button data-toggle="delete" data-callback='location.reload()'
                        data-url="{{ route('order_profit_diposites.destroy', $diposite) }}"
                        class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                @endif
            </div>
            <table class="table borderless">
                <tr>
                    <td class="td1">আইডি:</td>
                    <td><b>{{ bnConvert()->number($diposite->id) }}</b></td>
                </tr>
                <tr>
                    <td class="td1">মোট লাভ:</td>
                    <td><b>{{ bnConvert()->number($diposite->total_amount) }}</b> টাকা</td>
                </tr>
                <tr>
                    <td class="td1">সর্বমোট অর্ডার:</td>
                    <td><b>{{ bnConvert()->number($diposite->total_orders) }}</b> টি </td>
                </tr>
                <tr>
                    <td class="td1">স্টেটাস:</td>
                    <td>
                        @if ($diposite->is_approved)
                            <span class="badge badge-success span-badge">গ্রহণ করা হয়েছে</span>
                        @else
                            <span class="badge badge-warning span-badge">পেন্ডিং আছে</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="td1">জমা দিয়েছে:</td>
                    <td><span class="badge badge-secondary span-badge">{{ $diposite->user->name }}</span> </td>
                </tr>
                <tr>
                    <td class="td1">জমা হয়েছে:</td>
                    <td><span
                            title="{{ $diposite->created_at->format('d M Y H:i:s') }}">{{ bnConvert()->date($diposite->created_at->diffForHumans()) }}</span>
                    </td>
                </tr>
            </table>

        </div>
    @endforeach
</div>

    <div class="table-responsive desktop-area">
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

    </div>

    <div style="text-align: center">
        {{ $diposites->links() }}
    </div>
