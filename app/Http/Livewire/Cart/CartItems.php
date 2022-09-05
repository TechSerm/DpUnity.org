<?php

namespace App\Http\Livewire\Cart;

use App\Cart\Cart;
use Livewire\Component;

class CartItems extends Component
{
    protected $listeners = ['cartItemUpdate' => '$refresh'];
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
        //dd($this->items);
        $this->totalCartPrice = Cart::totalPrice();

        return view('store.cart.items');
    }
}
