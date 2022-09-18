<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;    

class StoreController extends Controller
{
    public function home()
    {
        $products = Product::paginate(6);
        return view('store.home.index', ['products' => $products]);
    }

    public function homeProducts()
    {
        $page = request()->page;
        $products = Product::paginate(6);
        return view('store.product.single_product_page', ['products' => $products]);
    }

    public function addCart(Request $request)
    {
        $productId = request()->id;
        $product = Product::where(['id' => $productId])->first();
        if (!$product) return;

        //Session::flush();

        Cart::update($product->id, 1);

       

        return redirect('/');
    }

    public function getCart()
    {

    }
}
