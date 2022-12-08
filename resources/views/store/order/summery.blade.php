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
<div class="checkout-details">
    <div class="details-header" style="background: #e67e22">
        আপনার বাজার করা পণ্য
    </div>
    <div class="details-body" style="padding: 0px">
        @livewire('cart.cart-items')
        @livewire('cart.cart-subtotal-area')
        <div class="confirmButtonArea">
            <a href="" class="btn btn-lg btn-primary mt-2" data-toggle="modal"
                data-target="#orderDetailsModal">অর্ডার করুন</a>
        </div>
    </div>
</div>
