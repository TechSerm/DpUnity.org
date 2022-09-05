

    <div class="text-right mb-2">
        <button data-toggle="modal" data-modal-size="md" data-modal-title="Update Customer Details" data-url="{{route('orders.customer.update', request()->route()->parameters())}}" type="button" class="btn btn-success">Edit</button>
    </div>

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Area</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Ip Address</th>
        <th>User Agent</th>
    </tr>
    <tr>
        <td>{{ $order->customer_name }}</td>
        <td>{{ $order->customer_area }}</td>
        <td>{{ $order->customer_address }}</td>
        <td>{{ $order->customer_phone }}</td>
        <td>{{ $order->customer_ip_address }}</td>
        <td>{{ $order->customer_user_agent }}</td>
    </tr>
</table>
