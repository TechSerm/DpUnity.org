<?php

namespace App\Http\Livewire\Cart;

use App\Cart\Cart;
use Livewire\Component;

class CartIndex extends Component
{
    protected $listeners = ['cartItemUpdate'];
    public function cartItemUpdate(){
        dd("Working");
    }
    public function render()
    {
        return view('store.cart.index', [
            'items' => Cart::items(),
            'totalCartPrice' => Cart::totalPrice()
        ])->layout('store.layout.layout');
    }
}
