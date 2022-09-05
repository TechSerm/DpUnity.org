<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        return view('store.cart.index', [
            'items' => Cart::items(),
            'totalPrice' => Cart::totalPrice()
        ]);
    }
}
