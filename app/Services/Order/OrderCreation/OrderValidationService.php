<?php

namespace App\Services\Order\OrderCreation;

use App\Cart\Cart;
use App\Facades\Order\OrderFacade;
use App\Facades\Order\OrderShippingDetails;
use Illuminate\Support\Facades\Validator;

class OrderValidationService
{

    public function validate($orderData, $productList)
    {
        if (OrderShippingDetails::isValidateFails()) {
            return [
                'body' => view("store.order.checkout.body_livewire", ['checkValidate' => true])->render(),
            ];
        }

        if (Cart::isEmpty()) {
            return [
                'message' => "আপনার ব্যাগে কোন পণ্য নেই।",
            ];
        }

        $activeOrders = OrderFacade::userOrder()->active();

        if (count($activeOrders) >= 3 && !auth()->check()) {
            return [
                'message' => "আপনার ইতিমধ্যে তিনটি অর্ডার পেন্ডিং এ আছে। আরও অর্ডার করতে আমাদের হট লাইনে যোগাযোগ করুন। আমাদের হটলাইন নম্বর " . config('bibisena.mobile_number') . "।",
            ];
        }

        return [];
    }

    public function isValidateFails()
    {
        $validator = Validator::make($this->get(true), $this->rules());
        return $validator->fails();
    }

    public function rules()
    {
        return [
            'fullName' => 'required',
            'phone' => 'required|regex:/^[01]{2}[0-9]{9}+$/',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'fullName.required' => 'The Name Address cannot be empty.',
            'phone.required' => 'মোবাইল নম্বর টি অবশ্যই আপনাকে পূরণ করতে হবে।',
            'phone.regex' => 'মোবাইল নম্বর টি সঠিক নই । মোবাইল নম্বর টি অবশ্যই বাংলাদেশী ১১ ডিজিট এর সঠিক নম্বর হতে হবে।',
            'address.required' => 'বাড়ির ঠিকানা টি অবশ্যই আপনাকে পূরণ করতে হবে।',
        ];
    }
}
