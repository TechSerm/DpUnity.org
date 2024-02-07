<div class="card mb-3">
    <style>
        .infoTd {
            text-align: right !important;
            font-weight: bold;
        }

        .infoTdRight {
            text-align: left !important;
        }
    </style>

    <style>
        .form-control-label {
            margin-top: -2px;
        }

        fieldset {
            background-color: #f9f9f9;
            border: 1px solid #eeeeee;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        legend {
            background-color: gray;
            color: white;
            width: 180px;
            font-size: 15px;
            padding: 2px;
            margin-left: 15px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>

    <div class="card-header">
        অর্ডার তথ্য
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-7">
                <fieldset>
                    <legend>
                        <div style="text-align: center">Order Info</div>
                    </legend>
                    <table class="table table-borderless">
                        <tr>
                            <td class="infoTd" style="width: 30%;">Order ID#: </td>
                            <td style="font-weight: bold; font-size: 16px;text-align: left">{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td class="infoTd">Order Created On:</td>
                            <td class="infoTdRight">{{ $order->created_at->format('d M Y, h:i a') }}
                                ({{ $order->created_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="infoTd">Status</td>
                            <td class="infoTdRight">
                                <span class="badge"
                                    style="background: {{ $order->status_color }}; color: #ffffff">
                                    {{ $order->status }}
                                </span>
                                @if ($order->isEditable())
                                    <button class="btn btn-primary btn-sm ml-2"><i class="fa fa-edit"></i> Change
                                        Status</button>
                                    <button class="btn btn-danger btn-sm"
                                        data-url="{{ route('orders.status.change', ['order' => $order->id, 'status' => 'canceled']) }}"
                                        data-toggle="confirm" data-title="Are you sure?"
                                        data-subtitle="Do you want to cancel this order?"
                                        data-button-text="Yes, Cancel Order!" data-cancel-button-text="Close"><i
                                            class="fa fa-times"></i> Cancel Order</button>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="infoTd">Payment Status:</td>
                            <td class="infoTdRight">
                                <span class="badge  badge-success">Paid</span> 
                                <button class="btn btn-primary btn-sm ml-2"><i class="fa fa-edit"></i> Change Payment Status</button>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div class="col-md-5">

                <fieldset>
                    <legend>
                        <div style="text-align: center">Shipping Address</div>
                    </legend>
                    <table class="table table-borderless">
                        <tr>
                            <td class="infoTd" style="width: 30%;">Name: </td>
                            <td class="infoTdRight">{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <td class="infoTd">Address:</td>
                            <td class="infoTdRight">{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <td class="infoTd">Mobile Number</td>
                            <td class="infoTdRight"> {{ $order->phone }}</td>
                        </tr>
                    </table>
                    <div class="text-right mb-2">
                        @if ($order->isEditable())
                            <button data-toggle="modal" data-modal-size="md" data-modal-title="Update Customer Details"
                                data-url="{{ route('orders.customer.update',request()->route()->parameters()) }}" type="button"
                                class="btn btn-sm btn-success">Edit Customer Info</button>
                        @endif
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="text-right mt-2">
            @can('order.info.history')
                <a class="btn btn-info" href="{{ route('invoice.print', ['order' => $order]) }}">Print Invoice</a>
                <button class="btn btn-primary" data-modal-title="Order Log" data-toggle="modal" data-modal-size="lg"
                    data-url="{{ route('orders.show.history',request()->route()->parameters()) }}">Log History</button>
            @endcan
        </div>

    </div>

</div>
