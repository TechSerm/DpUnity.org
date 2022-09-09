<?php

namespace App\Http\Livewire\Order;

use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class OrderDetails extends Component
{

    public $fullName;
    public $area;
    public $phone;

    public function mount()
    {
        $orderDetails = json_decode(Cookie::get('order_details'));
        $this->fullName = $orderDetails ? $orderDetails->full_name : '';
    }

    public function autoSave(){
        Cookie::queue('order_details', json_encode((object)[
            'full_name' => $this->fullName
        ]));
    }

    public function render()
    {
        $this->autoSave();
        sleep(3);
        return view('store.order.details');
    }
}
