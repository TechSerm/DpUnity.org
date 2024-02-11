<div class="card mb-3">
    <style>
        .infoTd {
            text-align: right !important;
            font-weight: bold;
            
        }

        .infoTdRight {
            text-align: left !important;
        }
        .orderinfo td{
            border-color: #f5f5f5!important;
        }
    </style>

    <style>
        .form-control-label {
            margin-top: -2px;
        }

        fieldset {
            
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
    <div class="card-body orderinfo">
        <div class="row">
            <div class="col-md-7">
                <fieldset>
                    <legend>
                        <div style="text-align: center">Order Info</div>
                    </legend>
                    <table class="table table-bordered">
                        <tr>
                            <td class="infoTd" style="">Order ID#: </td>
                            <td style="font-weight: bold; font-size: 16px;text-align: left">{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td class="infoTd">Order Created On:</td>
                            <td class="infoTdRight">{{ $order->created_at->format('d M Y, h:i a') }}
                                ({{ $order->created_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="infoTd">Status:</td>
                            <td class="infoTdRight">
                                {!! $order->status->badge() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="infoTd">Payment Status:</td>
                            <td class="infoTdRight">
                                {!! $order->payment_status->badge() !!}
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
                    <table class="table table-bordered">
                        <tr>
                            <td class="infoTd" style="width: 30%;">Name: </td>
                            <td class="infoTdRight">{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <td class="infoTd">Address:</td>
                            <td class="infoTdRight">{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <td class="infoTd">Mobile Number:</td>
                            <td class="infoTdRight"> {{ $order->phone }}</td>
                        </tr>
                    </table>
                    
                </fieldset>
            </div>
        </div>

        <div class="text-right mt-2">

                <button data-toggle="modal" data-modal-size="md" data-modal-title="Update Customer Details"
                                data-url="{{ route('orders.customer.update',request()->route()->parameters()) }}" type="button"
                                class="btn btn-primary">Edit</button>
                <a class="btn btn-info" href="{{ route('invoice.print', ['order' => $order]) }}">Print Invoice</a>
        </div>

    </div>

</div>
