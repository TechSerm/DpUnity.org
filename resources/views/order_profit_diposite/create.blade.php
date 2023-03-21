<form action="{{ route('order_profit_diposites.store') }}" method="post">
    @csrf
    <table class="table table-bordered table-striped" style="text-align: center">
        <thead>
            <tr>

                <th scope="col"><input type="checkbox" name="" id="vendorPaymentCheckboxAll"></th>
                <th scope="col">অর্ডার নম্বর</th>
                <th scope="col">পণ্যে লাভ</th>
                <th scope="col">ডেলিভারি ফি</th>
                <th scope="col">সর্বমোট</th>
                <th scope="col">অর্ডারটি করা হয়েছে</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>

                    <td><input type="checkbox" data-total="{{ $order->total_profit }}" class="OrderProfitPaymentCheckbox"
                            name="OrderProfitPaymentCheckbox[{{ $order->uuid }}]" id=""></td>
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
    <x-adminlte-small-box title="{{ bnConvert()->number($orders->sum('total_profit')) }} টাকা ({{ bnConvert()->number($orders->count()) }})"
        text="ক্যাশে জমা দেয়া বাকি আছে" icon="fas fa-times" theme="danger" />

    <div class="row">
        <div class="col-md-6 col-sm-6">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3><span id="totalSelectedAmount">{{ bnConvert()->number(0) }}</span> টাকা (<span
                            id="totalSelected">{{ bnConvert()->number(0) }}</span>)</h3>

                    <h5>সর্বমোট সিলেক্ট করা হয়েছে</h5>
                </div>


                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><span id="totalNoSelectedAmount">{{ bnConvert()->number($orders->sum('total_profit')) }}</span> টাকা
                    </h3>

                    <h5>সিলেক্ট করার পর বাকি আছে</h5>
                </div>


                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>


    <div class="mb-3 row">
        <label for="categories" class="col-sm-3 col-form-label form-control-label" for="image">নোট</label>
        <div class="col-sm-9">
            <textarea name="notes" class="form-control" id="" cols="30" rows="3"></textarea>
        </div>
        <label for="categories" class="col-sm-3 col-form-label form-control-label" for="image"></label>
        <div class="col-sm-9">
            <button type="submit" class="btn btn-success mt-2">লাভ ক্যাশে জমা করুন</button>
        </div>
    </div>

</form>
