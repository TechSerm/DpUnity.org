<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreOrderController extends Controller
{
    public function index()
    {
        return view('store.order.index');
    }
}
