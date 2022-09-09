<?php

namespace App\Http\Livewire\Cart;

use App\Cart\Cart;
use Livewire\Component;

class CartOrderButton extends Component
{
    public $totalCartPrice;
    protected $listeners = ['cartSubtotalUpdate' => '$refresh'];

    public function mount()
    {
        $this->totalCartPrice = Cart::totalPrice();
    }

    public function render()
    {
        $this->totalCartPrice = Cart::totalPrice();
        return view('store.cart.subtotal_area');
    }
}
