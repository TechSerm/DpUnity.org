<?php

namespace App\Http\Livewire;

use App\Cart\Cart;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class ShopFooter extends Component
{
    public $totalCart = 0;
    public $totalCartPrice = 0;
    public $currentUrl;

    protected $listeners = ['cartUpdate' => '$refresh'];

    public function mount()
    {
        $this->totalCart = count(Cart::items());
        $this->totalCartPrice = Cart::totalPrice();
        $this->currentUrl = $this->getCurrentPageUrl();
    }

    public function getCurrentPageUrl(){
        return rtrim(str_contains(URL::current(), 'livewire') ?  URL::previous() : URL::current(), '/');
    }

    public function render()
    {
        $this->totalCart = count(Cart::items());
        $this->totalCartPrice = Cart::totalPrice();
        $this->currentUrl = $this->getCurrentPageUrl();
        
        return view('store.layout.navbar');
    }
}
