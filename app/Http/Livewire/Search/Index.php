<?php

namespace App\Http\Livewire\Search;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('store.search.index')->layout('store.layout.layout');
    }
}
