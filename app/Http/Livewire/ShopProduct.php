<?php

namespace App\Http\Livewire;

use App\Cart\Cart;
use Livewire\Component;

class ShopProduct extends Component
{
    public $product;
    public $isShowPage;
    public $count = 1;

    public function mount($product, $isShowPage = false)
    {
        $this->product = $product;
        $this->count = $product->cartQuantity();
        $this->isShowPage = $isShowPage;
    }

    public function increment(){
        $this->count += 1;
        $this->product->cartUpdate($this->count);
        $this->emit('cartUpdate');
        $this->dispatchBrowserEvent('change-cart-animation');
    }

    public function decrement(){
        $this->count -= $this->count <= 0 ? 0 : 1;
        $this->product->cartUpdate($this->count);
        $this->emit('cartUpdate');
        $this->dispatchBrowserEvent('change-cart-animation');
    }

    public function render()
    {
       // sleep(1);
        return view('store.product.single_product');
    }
}
