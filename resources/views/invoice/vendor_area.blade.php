<div class="vendor-area">

    <div class="card" style="border-color: red">
        <div class="header" style="background: red; ">
            {{ App\Helpers\Constant::SITE_NAME }}
        </div>
        <center>
            <div class="label" style="background: red;">
                অর্ডার নাম্বারঃ {{ bnConvert()->number($order->id) }}
            </div>
        </center>

        <div class="body">
            <table style="width: 100%;z-index: 800">
                <tr>
                    <td class="td2" colspan="2">
                        <b>ক্যাশে জমা</b>
                    </td>
                </tr>
                <tr>
                    <td class="td1">তারিখঃ</td>
                    <td class="td2">
                        {{ bnConvert()->date($order->created_at->format('d M Y')) }}
                    </td>
                </tr>

                <tr>
                    <td class="td1">মোটঃ</td>
                    <td class="td2"><b>{{ bnConvert()->number($order->products_profit + $order->delivery_fee) }}</b>
                        টাকা</td>
                </tr>
            </table>
            <div class="coderoj_t">
                <img style="margin-left: 10px;margin-top: 5px;" height="60" width="180"
                    src="{{ asset('assets/img/bibisena_logo.png') }}">
            </div>
        </div>
    </div>

    @php
        $vendors = $order
            ->vendors()
            ->with('user')
            ->orderBy('wholesale_total', 'desc')
            ->get();
    @endphp

    @foreach ($vendors as $vendor)
        <div class="card" ng-repeat="user in users" style="border-color: green">
            <div class="header" style="background: green">
                {{ Config::get('constants.SITE_NAME') }}
            </div>
            <center>
                <div class="label" style="background: green">
                    অর্ডার নাম্বারঃ {{ bnConvert()->number($order->id) }}
                </div>
            </center>

            <div class="body">
                <table style="width: 100%;z-index: 800">
                    <tr>
                        <td class="td1">তারিখঃ</td>
                        <td class="td2">
                            {{ bnConvert()->date($order->created_at->format('d M Y')) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="td1">বিক্রেতাঃ</td>
                        <td class="td2">
                            {{ $vendor->user->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="td1">মোটঃ</td>
                        <td class="td2"><b>{{ bnConvert()->number($vendor->wholesale_total) }}</b> টাকা</td>
                    </tr>
                </table>
                <div class="coderoj_t">
                    <img style="margin-left: 10px;margin-top: 25px;" height="60" width="180"
                        src="{{ asset('assets/img/bibisena_logo.png') }}">
                </div>
            </div>
        </div>
    @endforeach
</div>
