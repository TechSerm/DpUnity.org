<?php

namespace App\Http\Controllers;

use App\Models\HomePageProduct;
use Illuminate\Http\Request;

class HomePageProductController extends Controller
{
    public function index()
    {
        $products = HomePageProduct::orderBy('serial_no', 'asc')->get();
        return view('home_page_product.index', [
            'products' => $products
        ]);
    }
}
