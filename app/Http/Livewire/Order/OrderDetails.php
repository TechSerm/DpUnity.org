<?php

namespace App\Http\Livewire\Order;

use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class OrderDetails extends Component
{

    public $fullName;
    public $phone;
    public $address;

    protected $rules = [
        'fullName' => 'required',
        'phone' => 'required|regex:/^[01]{2}[0-9]{9}+$/',
        'address' => 'required',
    ];

    protected $messages = [
        'fullName.required' => 'The Email Address cannot be empty.',
        'phone.required' => 'মোবাইল নম্বর টি অবশ্যই আপনাকে পূরণ করতে হবে।',
        'phone.regex' => 'মোবাইল নম্বর টি সঠিক নই । মোবাইল নম্বর টি অবশ্যই বাংলাদেশী ১১ ডিজিট এর সঠিক নম্বর হতে হবে।',
        'address.required' => 'বাড়ির ঠিকানা টি অবশ্যই আপনাকে পূরণ করতে হবে।',
    ];

    public function updated($propertyName)
    {
        $this->autoSave();
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $orderDetails = json_decode(Cookie::get('order_details'));
        $this->fullName = $orderDetails && $orderDetails->full_name ? $orderDetails->full_name : '';
        $this->address = $orderDetails && isset($orderDetails->address) ? $orderDetails->address : '';
        $this->phone = $orderDetails && isset($orderDetails->phone) ? $orderDetails->phone : '';
    }

    public function autoSave()
    {
        Cookie::queue('order_details', json_encode((object)[
            'full_name' => $this->fullName,
            'address' => $this->address,
            'phone' => $this->phone,
        ]));
    }

    public function render()
    {
        return view('store.order.details');
    }
}
