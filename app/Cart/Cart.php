<?php

namespace App\Cart;

use App\Models\Product;
use Carbon\Carbon;
use Cookie;


class Cart
{
    public static function items()
    {
        $cart = CartAction::get();
        $response = [];
        foreach ($cart as $productId => $quantity) {
            $product = Product::where(['id' => $productId])->select(['id', 'name', 'image_id', 'price', 'unit', 'quantity'])->first();
            if ($product) {
                $product->cart_quantity = $quantity;
                $product->cart_total_price = $quantity * $product->price;
                array_push($response, (object)$product);
            }
        }
        return $response;
    }

    public static function totalPrice()
    {
        $items = collect(self::items());
        return $items->sum('cart_total_price');
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
