<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Facades\HomePageProduct\HomePageProductFacade;
use App\Facades\Order\OrderFacade;
use App\Models\Category;
use App\Models\Product;
use App\Models\SurveyResponse;
use App\Services\DeviceToken\DeviceTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;


class StoreController extends Controller
{
    public function home()
    {
        $products = HomePageProductFacade::get();
        $hotDealProducts = Product::active()->where(['has_hot_deals' => true])->with('imageTable')->take(12)->get();

        return view('store.home.index', [
            'products' => $products,
            'categories' => Category::with('imageTable', 'products')->get(),
            'hotDealProducts' => $hotDealProducts
        ]);
    }

    public function hotDeals()
    {
        $hotDealProducts = Product::active()->where(['has_hot_deals' => true])->with('imageTable')->get();

        return view('store.hot_deals.index', [
            'hotDealProducts' => $hotDealProducts
        ]);
    }

    public function profile()
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        return view('store.profile.index');
    }

    public function getCacheId()
    {
        return Cookie::has("temp_usr_cache_f1") ? Cookie::get("temp_usr_cache_f1") : '';
    }

    public function homeProducts()
    {
        $page = request()->page;
        $products = HomePageProductFacade::get();
        return view(request()->ajax() ? 'store.product.single_product_page' : 'store.product.single_product_page_with_ui', ['products' => $products]);
    }

    public function addCart(Request $request)
    {
        $productId = request()->product_id;
        $quantity = request()->quantity ?? 1;
        $quantity = (int)$quantity;

        $product = Product::where(['id' => $productId])->firstOrFail();
        if (!$product) return;

        Cart::update($product->id, is_int($quantity) ? $quantity : 1);

        return response()->json([
            'message' => "Product successfully added to your cart",
            'url' => route('cart')
        ]);
    }

    public function getCart()
    {
    }


    public function showProduct($productId)
    {
        $product = Product::findOrFail($productId);
        return view('store.product.single_product_full_page', ['product' => $product]);
    }
}
