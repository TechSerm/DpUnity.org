<?php

namespace App\Http\Livewire\Cart;

use App\Cart\Cart;
use Livewire\Component;

class CartItems extends Component
{
    public $items = [];
    public $totalCartPrice;

    public function mount()
    {
        $this->items = Cart::items();
        $this->totalCartPrice = Cart::totalPrice();
    }

    public function render()
    {
        $this->items = Cart::items();
        return view('store.cart.items');
    }
}
