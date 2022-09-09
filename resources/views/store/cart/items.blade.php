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
        @livewire('cart.cart-order-button')
    </center>

</div>
