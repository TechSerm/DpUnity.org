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

class StoreController extends Controller
{
    public function home()
    {
        $products = HomePageProductFacade::get();
        $activeOrders = OrderFacade::userOrder()->activeOrToday();
        $ramadanCategory = Category::find(env('RAMADAN_CATEGORY_ID'));
        $ramadanCategoryProducts = $ramadanCategory ? $ramadanCategory->products()->with(['imageTable'])->get() : [];
        $iftarCategory = Category::find(env('IFTAR_CATEGORY_ID'));
        $iftarCategoryProducts = $iftarCategory ? $iftarCategory->products()->with(['imageTable'])->get() : [];
        return view('store.home.index', [
            'products' => $products,
            'categories' => Category::with('imageTable', 'products')->get(),
            'activeOrders' => $activeOrders,
            'ramadanCategoryProducts' => $ramadanCategoryProducts,
            'iftarCategoryProducts' => $iftarCategoryProducts
        ]);
    }

    public function homeProducts()
    {
        $page = request()->page;
        $products = HomePageProductFacade::get();
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

    public function surveyFormSave(Request $request)
    {
        $data = [
            'address' => $request->address,
            'mobile_number' => $request->address,
            'total_member' => $request->address,
            'member_under_18' => $request->address,
            'occupation' => $request->address,
            'income' => $request->address,
            'time_save' => $request->address,
            'category' => $request->category
        ];

        $deviceId = (new DeviceTokenService())->getCacheId();


        dd($deviceId);
        $requestData = [
            'survey_key' => 1,
            'survey_body' => json_encode($data),
            'user_id' => auth()->user()->id
        ];

        if(empty($deviceId)){
            $requestData['device_id'] = $deviceId;
        }

        SurveyResponse::create($requestData);

        return redirect('/');
    }

    public function showProduct($productId)
    {
        $product = Product::findOrFail($productId);
        return view('store.product.show', ['product' => $product]);
    }
}
