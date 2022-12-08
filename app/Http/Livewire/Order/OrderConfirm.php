<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;

class OrderConfirm extends Component
{

    public function mount(){

    }

    public function confirm(){
        $this->emit('confirmOrder');
    }

    public function render()
    {
        return view('store.order.checkout.modal');
    }
}
