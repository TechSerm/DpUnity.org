<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ShopProducts extends Component
{
    public $cpage = 2;
    public $products;

    public function mount()
    {
        $products = Product::all();

        $mProducts = Product::all();
        
        for($i=1; $i<$this->cpage; $i++)$products = $products->concat($mProducts);

        $this->products = $products;
    }

    public function barau(){
        $this->cpage += 1;
        $products = Product::all();

        $mProducts = Product::all();
        
        for($i=1; $i<$this->cpage; $i++)$products = $products->concat($mProducts);

        $this->products = $products;
    }

    public function render()
    {
        sleep(1);
        return view('store.product.single_product_page');
    }
}
