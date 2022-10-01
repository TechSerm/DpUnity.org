<?php

namespace App\Http\Livewire\Cart;

use App\Cart\Cart;
use Livewire\Component;

class CartSubtotalArea extends Component
{
    protected $listeners = ['updateCartSubtotalArea' => 'updateCartPrice' ];
    public $totalCartPrice;
    public $deliveryFee;
    public $totalPayablePrice;

    public function mount()
    {
        $this->updateCartPrice();
    }

    public function updateCartPrice()
    {
        $this->totalCartPrice = Cart::totalPrice();
        $this->deliveryFee = Cart::getDeliveryFee();
        $this->totalPayablePrice = Cart::getTotalWithDeliveryFee();
    }

    public function render()
    {
        return view('store.cart.subtotal_area');
    }
}
