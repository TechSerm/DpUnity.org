<div>
    <table class="table table-responsive-sm">
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        
        @foreach ($items as $key => $item)
            @livewire('cart.cart-item', ['item' => $item])
        @endforeach

    </table>

    <center>
        <button class="btn btn-primary">অর্ডার করুন {{$totalCartPrice}}</button>
    </center>

</div>
