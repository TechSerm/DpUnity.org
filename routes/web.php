<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchKeywordController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StoreOrderController;
use Illuminate\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['device_token_check','check_push_notification_click'])->group(function () {
    Route::get('/',  [StoreController::class, 'home'])->name('home');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search-product', [SearchController::class, 'getSearchProduct'])->name('search.products');
    //Route::get('/', [StoreController::class, 'home'])->name('store.home');
    Route::get('/home-products', [StoreController::class, 'homeProducts'])->name('store.home.products');
    Route::get('/product/{product}', [StoreController::class, 'showProduct'])->name('store.product.show');

    Route::get('/cart', \App\Http\Livewire\Cart\CartIndex::class)->name('cart');

    Route::get('/order', [StoreOrderController::class, 'index'])->name('store.order');
    Route::post('/order', [StoreOrderController::class, 'create']);
    Route::get('/order/{uuid}', [StoreOrderController::class, 'show'])->name('store.order.show');
    
});


Route::prefix('admin')->group(function () {

    Route::middleware(['auth'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.home');

        //product routes
        Route::get('/products/data', [ProductController::class, 'getData'])->name('products.data');
        Route::get('/products/{product}/history', [ProductController::class, 'history'])->name('products.history');
        Route::get('/products/{product}/sync', [ProductController::class, 'sync'])->name('products.sync');
        Route::resource('products', ProductController::class);

        Route::get('/categories/select2_data', [CategoryController::class, 'getSelect2Data'])->name('categories.select2_data');
        Route::get('/categories/data', [CategoryController::class, 'getData'])->name('categories.data');
        Route::get('/categories/{category}/history', [CategoryController::class, 'history'])->name('categories.history');
        Route::resource('categories', CategoryController::class);

        //order routes
        Route::get('/orders/data', [OrderController::class, 'getData'])->name('orders.data');
        Route::post('/orders/{order}/change_order_status/{order_status}', [OrderController::class, 'changeOrderStatus'])->name('orders.status.change');
        Route::get('/orders/{order}/update_customer_details', [OrderController::class, 'showUpdateCustomer'])->name('orders.customer.update');
        Route::put('/orders/{order}/update_customer_details', [OrderController::class, 'updateCustomer']);
        Route::resource('orders', OrderController::class);

        Route::get('/search-keywords/data', [SearchKeywordController::class, 'getData'])->name('search-keywords.data');
        Route::resource('search-keywords', SearchKeywordController::class);

        Route::get('/shippings/data', [ShippingController::class, 'getData'])->name('shippings.data');
        Route::resource('shippings', ShippingController::class);
        
        Route::get('/push_notifications/data', [PushNotificationController::class, 'getData'])->name('push_notifications.data');
        Route::resource('push_notifications', PushNotificationController::class);
        Route::post('/push_notifications/test', [PushNotificationController::class, 'sendTestPushNotification'])->name('push_notifications.test');
    
        
        Route::get('/settings', [ResetPasswordController::class, 'showResetForm'])->name('admin.settings');
    });


    Route::post('/upload', [HomeController::class, 'upload'])->name('upload');

    Route::middleware(['cors'])->group(function () {
        Route::get('/log', [HomeController::class, 'log'])->name('log');
    });

    Auth::routes();
});
