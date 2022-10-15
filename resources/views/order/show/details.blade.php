<div class="text-right mb-2">
    <button data-toggle="modal" data-modal-size="md" data-modal-title="Update Customer Details"
        data-url="{{ route('orders.customer.update',request()->route()->parameters()) }}" type="button"
        class="btn btn-success">Edit Order Customer Info</button>
</div>

<table class="table table-bordered">
    <tr>
        <td>Order No</td>
        <td>{{ $order->id }}</td>
    </tr>
    <tr>
        <td>Order Created</td>
        <td>{{ $order->created_at }}</td>
    </tr>
    <tr>
        <td>Order Status</td>
        <td>{{ $order->status }}</td>
    </tr>
    <tr>
        <td>Name</td>
        <td>{{ $order->name }}</td>
    </tr>
    <tr>
        <td>Address</td>
        <td>{{ $order->address }}</td>
    </tr>
    <tr>
        <td>Phone</td>
        <td>{{ $order->phone }}</td>
    </tr>
    <tr>
        <td>Ip Address</td>
        <td>{{ $order->ip_address }}</td>
    </tr>
    <tr>
        <td>User Agent</td>
        <td>{{ substr($order->user_agent, 0, 40) }}</td>
    </tr>
</table>
