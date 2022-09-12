<div>
    <style>
        .cartTable {
            font-family: 'SolaimanLipi', Arial, sans-serif;
            text-align: justify;
        }
    </style>
    <table class="table cartTable">
    
        @foreach ($items as $key => $item)
            @livewire('cart.cart-item', ['item' => $item])
            @livewire('cart.cart-item', ['item' => $item])
            @livewire('cart.cart-item', ['item' => $item])
        @endforeach

    </table>

</div>
