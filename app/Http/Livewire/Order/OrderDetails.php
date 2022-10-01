<?php

namespace App\Http\Livewire\Order;

use App\Facades\Order\OrderShippingDetails;
use App\Services\Order\OrderDetailsService;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class OrderDetails extends Component
{

    public $fullName;
    public $phone;
    public $address;

    protected $rules;
    protected $messages;

    public function __construct()
    {
        $this->rules = OrderShippingDetails::rules();
        $this->messages = OrderShippingDetails::messages();
    }

    public function confirmOrder()
    {
        $this->validate();
    }

    public function updated($propertyName)
    {
        $this->autoSave();
        $this->validateOnly($propertyName);
    }

    public function mount($checkValidate = false)
    {
        $orderDetails = OrderShippingDetails::get();
        $this->fullName = $orderDetails && isset($orderDetails->fullName) ? $orderDetails->fullName : '';
        $this->address = $orderDetails && isset($orderDetails->address) ? $orderDetails->address : '';
        $this->phone = $orderDetails && isset($orderDetails->phone) ? $orderDetails->phone : '';

        if ($checkValidate == true) $this->validate();
    }

    public function autoSave()
    {
        OrderShippingDetails::save((object)[
            'fullName' => $this->fullName,
            'address' => $this->address,
            'phone' => $this->phone,
        ]);
    }

    public function render()
    {
        return view('store.order.details');
    }
}
