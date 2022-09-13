<?php

namespace App\Http\Livewire\Cart;

use App\Models\Product;
use Livewire\Component;

class CartItem extends Component
{
    public $item;
    public $productId;
    public $totalQuantity;
    public $product;
    public $totalPrice;

    public function mount($item)
    {
        $this->item = $item;
        $this->totalQuantity = $item->cart_quantity;
        $this->id = $item->id;
        $this->product = Product::find($this->id);
        $this->totalPrice = $item->cart_total_price;
    }

    public function increment()
    {
        $this->totalQuantity += 1;
        $this->updateCart();
    }

    public function decrement()
    {
        $this->totalQuantity -= 1;
        $this->updateCart();
    }

    public function updateCart(){
        $this->product->cartUpdate($this->totalQuantity);
        $this->totalPrice = $this->item->price * $this->totalQuantity;
      //  $this->emit('cartItemUpdate');
        $this->emit('cartUpdate');
        $this->emit('cartSubtotalUpdate');
        $this->dispatchBrowserEvent('change-cart-animation');
    }

    public function render()
    {
        return view('store.cart.item');
    }
}
