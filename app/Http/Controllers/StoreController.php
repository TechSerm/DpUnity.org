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
        $activeOrders = OrderFacade::userOrder()->activeOrToday();
        $freeProduct = Product::where(['id' => env('FREE_PRODUCT_ID')])->first();

        if (isset(request()->s) || isset(request()->n)) {
            $this->updateData();
        }

        return view('store.home.index', [
            'products' => $products,
            'categories' => Category::with('imageTable', 'products')->get(),
            'activeOrders' => $activeOrders,
            'freeProduct' => $freeProduct
        ]);
    }

    public function profile()
    {
        if(!auth()->check()){
            return redirect('login');
        }

        return view('store.profile.index');
    }

    // need to delete further
    private function updateData()
    {
        $publicPath = public_path("file/user.json");
        $data = File::get($publicPath);
        $dataArray = json_decode($data, true);
        $tempId = $this->getCacheId();
        if ($tempId == '') {
            $tempId = collect($dataArray)->max(function ($item) {
                return $item['id'];
            }) + 1;
            $this->createCacheId($tempId);
        }

        $sendId = isset(request()->s) ? request()->s : request()->n;
        $type = isset(request()->s) ? 'sms' : 'notification';

        $exits = collect($dataArray)->where('id', $tempId)->where('type', $type)->where('send_id', $sendId)->first();
        if ($exits) return;

        $newData = [
            'id' => $tempId,
            'type' => isset(request()->s) ? 'sms' : 'notification',
            'send_id' => isset(request()->s) ? request()->s : request()->n,
            'ip' => request()->ip(),
            'user' => auth()->user() ? auth()->user()->name : '',
            'time' => Carbon::now()->toDateTimeString(),
        ];
        $dataArray[] = $newData;
        $updatedData = json_encode($dataArray, JSON_PRETTY_PRINT);

        // Write the updated data back to the file
        File::put($publicPath, $updatedData);
    }
    //end delete part

    public function getCacheId()
    {
        return Cookie::has("temp_usr_cache_f1") ? Cookie::get("temp_usr_cache_f1") : '';
    }

    private function createCacheId($deviceId)
    {
        Cookie::queue("temp_usr_cache_f1", $deviceId, "2628000");
    }

    public function homeProducts()
    {
        $page = request()->page;
        $products = HomePageProductFacade::get();
        return view(request()->ajax() ? 'store.product.single_product_page' : 'store.product.single_product_page_with_ui', ['products' => $products]);
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


    public function showProduct($productId)
    {
        $product = Product::findOrFail($productId);
        return view('store.product.single_product_full_page', ['product' => $product]);
    }
}
