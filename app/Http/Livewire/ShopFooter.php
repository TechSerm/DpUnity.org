<?php

namespace App\Http\Livewire;

use App\Cart\Cart;
use Livewire\Component;

class ShopFooter extends Component
{
    public $totalCart = 0;

    protected $listeners = ['cartUpdate' => '$refresh'];

    public function mount()
    {
        $this->totalCart = count(Cart::items());
    }

    public function render()
    {
        $this->totalCart = Cart::totalPrice();
        return view('store.layout.navbar');
    }
}
