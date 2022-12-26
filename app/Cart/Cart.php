<?php

namespace App\Cart;

use App\Models\Product;
use Carbon\Carbon;
use Cookie;


class Cart
{
    public static $cartProductItems;
    public static function items()
    {
        if(!empty(self::$cartProductItems))return self::$cartProductItems;
        $cart = CartAction::get();
        $products = Product::with('imageTable')->whereIn('id', array_keys($cart))->select(['id', 'name', 'image_id', 'price', 'unit', 'quantity','delivery_fee'])->get();

        $response = [];
        foreach ($products as $product) {
            if(!isset($cart[$product->id]))continue;
            
            $quantity = $cart[$product->id];
            $product->cart_quantity = $quantity;
            $product->cart_total_price = $quantity * $product->price;
            $product->delivery_fee = is_null($product->delivery_fee) ? config('bibisena.default_delivery_fee') : $product->delivery_fee;
            array_push($response, (object)$product);
            
        }
        return self::$cartProductItems = $response;
    }

    public static function isEmpty()
    {
        $products = self::items();
        return empty($products);
    }

    public static function totalPrice()
    {
        $items = collect(self::items());
        return $items->sum('cart_total_price');
    }

    public static function getDeliveryFee()
    {
        $items = collect(self::items());
        return (int)$items->max('delivery_fee');
    }

    public static function getTotalWithDeliveryFee()
    {
        return self::totalPrice() + self::getDeliveryFee();
    }

    public static function clear()
    {
        return  CartAction::clear();
    }

    public static function add($productId, $quantity)
    {
        $cart = CartAction::get();
        $cart[$productId] = isset($cart[$productId]) ? $cart[$productId] + $quantity : $quantity;
        CartAction::save($cart);
    }

    public static function update($productId, $quantity)
    {
        $cart = CartAction::get();
        $cart[$productId] = isset($cart[$productId]) ? $quantity : $quantity;
        //    dd($cart);
        CartAction::save($cart);
    }

    public static function remove($productId)
    {
        $cart = CartAction::get();
        if (isset($cart[$productId])) $cart[$productId] = 0;
        CartAction::save($cart);
    }

    public static function quantity($productId)
    {
        $cart = CartAction::get();
        return isset($cart[$productId]) ? $cart[$productId] : 0;
    }
}
