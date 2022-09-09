<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('store.home.index')->layout('store.layout.layout');
    }
}
