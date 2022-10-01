<?php

namespace App\Http\Livewire\Cart;

use App\Cart\Cart;
use Livewire\Component;

class CartItems extends Component
{
    public $items = [];

    public function mount()
    {
        $this->items = Cart::items();
    }

    public function render()
    {
        return view('store.cart.items');
    }
}
