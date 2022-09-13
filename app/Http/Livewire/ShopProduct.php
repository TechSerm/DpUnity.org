<?php

namespace App\Http\Livewire;

use App\Cart\Cart;
use Livewire\Component;

class ShopProduct extends Component
{
    public $product;
    public $count = 1;

    public function mount($product)
    {
        $this->product = $product;
        $this->count = $product->cartQuantity();
    }

    public function increment(){
        $this->count += 1;
        $this->product->cartUpdate($this->count);
        $this->emit('cartUpdate');
        $this->dispatchBrowserEvent('change-cart-animation');
    }

    public function decrement(){
        $this->count -= 1;
        $this->product->cartUpdate($this->count);
        $this->emit('cartUpdate');
        $this->dispatchBrowserEvent('change-cart-animation');
    }

    public function render()
    {
        return view('store.product.single_product');
    }
}
