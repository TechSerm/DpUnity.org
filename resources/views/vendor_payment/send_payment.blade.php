<form action="{{ route('vendor_payments.store', ['vendor_id' => request()->vendor_id]) }}" method="post">
    @csrf
    <table class="table table-bordered" style="text-align: center">
        <thead>
            <tr>
                @if (auth()->user()->isAdmin())
                    <th scope="col"><input type="checkbox" name="" id="vendorPaymentCheckboxAll"></th>
                @endif
                <th scope="col">অর্ডার নম্বর</th>
                <th scope="col">সর্বমোট</th>
                <th scope="col">অর্ডারটি করা হয়েছে</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendor['not_send_ids'] as $order)
                <tr>
                    @if (auth()->user()->isAdmin())
                        <td><input type="checkbox" data-total="{{ $order['total'] }}" class="vandorPaymentCheckbox"
                                name="vandorPaymentCheckbox[{{ $order['uuid'] }}]" id=""></td>
                    @endif
                    <th scope="row"><a href="{{route('vendor_payments.show_order', ['vendor_id' => request()->vendor_id,'order_id' => $order['uuid']])}}" data-modal-header="Order {{$order['order_id']}}" data-toggle="modal">{{ bnConvert()->number($order['order_id']) }}</a></th>
                    <td><b>{{ bnConvert()->number($order['total']) }}</b> টাকা</td>
                    <td><span
                            title='{{ $order['date'] }}'>{{ bnConvert()->date($order['date']->diffForHumans()) }}</span>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <x-adminlte-small-box
        title="{{ bnConvert()->number($vendor['not_send']) }} টাকা ({{ bnConvert()->number(count($vendor['not_send_ids'])) }})"
        text="বিক্রেতার বাকি আছে" icon="fas fa-times" theme="danger" />

    @if (auth()->user()->isAdmin())
        <div class="row">
            <div class="col-md-6 col-sm-6">
                
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><span id="totalSelectedAmount">{{ bnConvert()->number(0) }}</span> টাকা (<span id="totalSelected">{{ bnConvert()->number(0) }}</span>)</h3>

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
                            <h3><span id="totalNoSelectedAmount">{{ bnConvert()->number($vendor['not_send']) }}</span> টাকা (<span id="totalNoSelected">{{ bnConvert()->number(count($vendor['not_send_ids'])) }}</span>)</h3>
    
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
                    <button type="submit" class="btn btn-success mt-2">বিক্রেতার টাকা পাঠান</button>
                </div>
            </div>
    @endif

</form>
