<style>
    .confirmButtonArea {
        text-align: right;
    }

    @media screen and (max-width: 767px) {
        .confirmButtonArea {
            display: none;
        }
    }

    .shoppingCartBag {
        display: none;
    }
</style>

<div class="details-body" style="padding: 0px">
    @livewire('cart.cart-items')
    @livewire('cart.cart-subtotal-area')
</div>
