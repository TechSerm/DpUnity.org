<div class="orderDetails mb-3">
    <div class="header" style="background: #8e44ad">
        অর্ডার অবস্থা
    </div>
    <div class="body">
        <table class="table table-bordered">
            @php
                $totalPendingStatus = 0;
                $orderStatusList = $order->statusList;
                $alreadyCanceled = false;

                
            @endphp
            @foreach ($orderStatusList as $status)
                @php
                    $totalPendingStatus += $status->status == 'pending' ? 1 : 0;

                    $isVisibleYesButton = false;

                    if(auth()->user()->isAdmin())$isVisibleYesButton = true;
                    else {
                        if(in_array($status->name, ['vendor_payment_received', 'received_by_store', 'pack_complete', 'start_delivery', 'delivery_completed'])){
                            $isVisibleYesButton = true;
                        }
                    }

                    if ($status->status == 'cancelled') {
                        $alreadyCanceled = true;
                    }
                @endphp
                <tr>
                    <td style="text-align: right; max-width: 400px">
                        {{ $status->bn_name }}
                    </td>
                    <td>
                        @if ($totalPendingStatus == 1 && $alreadyCanceled == false)
                            @if($isVisibleYesButton)
                            <button class="btn btn-success"
                                data-url="{{ route('orders.status.change', ['order' => $order, 'order_status' => $status->uuid]) }}"
                                data-toggle="confirm" data-title="আপনি কি নিশ্চিত?"
                                data-subtitle="অর্ডারটি {{ $status->bn_name }}?" data-button-text="হ্যা, আমি নিশ্চিত!"
                                data-cancel-button-text="বন্ধ করুন">হ্যা!</button>
                            @endif
                            @if (auth()->user()->isAdmin() && $status->name != 'vendor_payment_send' && $status->name != 'vendor_payment_received')
                                <button class="btn btn-danger"
                                data-url="{{ route('orders.status.change', ['order' => $order, 'order_status' => $status->uuid, 'cancelled' => 'true']) }}"
                                data-toggle="confirm" data-title="আপনি কি নিশ্চিত?"
                                data-subtitle="অর্ডারটি বাতিল করতে চাচ্ছেন?"
                                data-button-text="হ্যা, আমি বাতিল করতে চাচ্ছি!"
                                data-cancel-button-text="বন্ধ করুন">বাতিল করুন</button>

                            @endif
                        @endif
                        @if ($status->status == 'approved')
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                        @elseif ($status->status == 'cancelled')
                            <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                        @endif

                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
{{-- 
<div class="track">
    <div class="step step1 active">
        <span class="icon">
            <i class="fa fa-check"></i>
        </span>
        <span class="text">Varification</span>

    </div>
    <div class="step step1 active">
        <span class="icon">
            <i class="fa fa-check"></i>
        </span>
        <span class="text">Assign Store</span>

    </div>
    <div class="step step1 active">
        <span class="icon">
            <i class="fa fa-check"></i>
        </span>
        <span class="text">Store Received</span>

    </div>
    <div class="step step1 active">
        <span class="icon">
            <i class="fa fa-check"></i>
        </span>
        <span class="text">Pack Complete</span>
        <button class="btn btn-sm btn-success mr-1">Yes</button>
        <button class="btn btn-sm btn-danger">Cancel</button>
    </div>
    <div class="step step1 active">
        <span class="icon">
            <i class="fa fa-check"></i>
        </span>
        <span class="text">Start Delivery</span>
        <button class="btn btn-sm btn-success mr-1">Yes</button>
        <button class="btn btn-sm btn-danger">Cancel</button>
    </div>
    <div class="step step1 non_active t_progress">
        <span class="icon">
            <i class="fas fa-spinner fa-spin"></i>
        </span>
        <span class="text">Delivery Complete</span>
        <button class="btn btn-sm btn-success mr-1">Yes</button>
        <button class="btn btn-sm btn-danger">Cancel</button>
    </div>
    <div class="step step1 non_active">
        <span class="icon"><i class="fa fa-user"></i> </span>
        <span class="text">Payment Send</span>
    </div>
    <div class="step">
        <span class="icon"><i class="fa fa-user"></i> </span>
        <span class="text">Payment Received</span>
    </div>
</div>
<style>
    .track {
        position: relative;
        background-color: #ffffff;
        height: 7px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 60px;
        margin-top: 50px
    }

    .track .step {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .step.active:before {
        background: #017c3d
    }

    .track .step.non_active:before {
        background: #ddd
    }

    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 50%;
        left: 50%;
        top: 18px
    }

    .track .step1::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 50%;
        top: 18px
    }

    .track .step.active .icon {
        background: #017c3d;
        color: #fff
    }

    .track .step.t_progress .icon {
        background: #060445;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .step.active .text {
        color: #000
    }

    .track .text {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 14px;
        margin-top: 7px
    }
</style> --}}
