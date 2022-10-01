<?php

namespace App\Services\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class OrderShippingDetailsService
{
    private $orderKey = 'order_details';

    public function save($orderDeatailsData)
    {
        Cookie::queue($this->orderKey, json_encode((object)[
            'fullName' => $orderDeatailsData->fullName,
            'address' => $orderDeatailsData->address,
            'phone' => $orderDeatailsData->phone,
        ]), 2628000);
    }

    public function get($isArray = false)
    {
        return json_decode(Cookie::get($this->orderKey), $isArray);
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
