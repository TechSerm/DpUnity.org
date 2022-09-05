<?php

namespace App\Cart;

use App\Models\Product;
use Carbon\Carbon;
use Cookie;
use Illuminate\Support\Facades\Session;    

class CartAction
{
    private static $cartKey = "shop_cart";

    public static function get()
    {
        $cart = Session::get(self::$cartKey);
        return empty($cart) ? [] : $cart;
    }

    public static function save($cart)
    {
        foreach($cart as $key => $value){
            if($value <= 0)unset($cart[$key]);
        }
        if(empty($cart))$cart = [];
        return Session::put(self::$cartKey, $cart);
    }

    public static function clear(){
        return  Session::forget(self::$cartKey);
    }
    
}
