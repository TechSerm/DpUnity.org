<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 1;

    // protected $listeners = ['cartItemUpdate' => '$refresh' ];
    
    public function increment()
    {
        $this->count += 1;
    }

    public function decrement(){
        $this->count -= 1;
    }

    public function render()
    {
        dd("Working");
        return view('store.product.single_product');
    }
}
