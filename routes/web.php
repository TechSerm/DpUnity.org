<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomePageProductController;
use App\Http\Controllers\NotificationDeviceController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchKeywordController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StoreCategoryController;
use App\Http\Controllers\StoreOrderController;
use App\Http\Controllers\VendorPaymentController;
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

    Route::get('/order/list', [StoreOrderController::class, 'orderList'])->name('store.order.list');

    Route::get('/order', [StoreOrderController::class, 'index'])->name('store.order');
    Route::post('/order', [StoreOrderController::class, 'create']);
    Route::get('/order/{uuid}', [StoreOrderController::class, 'show'])->name('store.order.show');

    Route::get('/categories', [StoreCategoryController::class, 'index'])->name('store.categories');
    Route::get('/categories/{category}', [StoreCategoryController::class, 'show'])->name('store.categories.show');
    
});


Route::prefix('admin')->group(function () {

    Route::middleware(['auth','device_token_check','check_push_notification_click'])->group(function () {
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
        Route::get('/orders/active', [OrderController::class, 'activeOrders']);
        Route::post('/orders/{order}/change_order_status/{status}', [OrderController::class, 'changeOrderStatus'])->name('orders.status.change');
        Route::get('/orders/{order}/update_customer_details', [OrderController::class, 'showUpdateCustomer'])->name('orders.customer.update');
        Route::put('/orders/{order}/update_customer_details', [OrderController::class, 'updateCustomer']);
        Route::prefix('orders/{order}')->middleware(['order_show_page_check'])->group(function () {
            Route::get('/update_vendor', [OrderController::class, 'showVendor'])->name('orders.vendor.update');
            Route::put('/update_vendor', [OrderController::class, 'updateVendor']);
            Route::get('/product_select2_data', [OrderItemController::class, 'getProductSelect2Data'])->name('orders.order_items.product_select2_data');
            Route::get('/product_create_form', [OrderItemController::class, 'productCreateForm'])->name('orders.order_items.create_form');
            Route::resource('order_items', OrderItemController::class);
            Route::get('/assign_product_vendor_list', [OrderController::class, 'assignProductVendorList'])->name('orders.vendor.assign_product_vendor_list');
            Route::post('/assign_product_vendor_list', [OrderController::class, 'updateAssignProductVendorList']);
        });

        Route::get('/orders/{order}/print', [OrderController::class, 'printOrder'])->name('orders.print');
        Route::resource('orders', OrderController::class);

        Route::get('/product_name_suggestions', [ProductController::class, 'getSuggestionsProductName'])->name('product.name_suggestions');
        
        Route::get('/product_price', [ProductController::class, 'productPrice'])->name('product_price.index');
        Route::post('/product_price', [ProductController::class, 'productPriceUpdate']);

        Route::get('/search-keywords/data', [SearchKeywordController::class, 'getData'])->name('search-keywords.data');
        Route::resource('search-keywords', SearchKeywordController::class);

        Route::get('/shippings/data', [ShippingController::class, 'getData'])->name('shippings.data');
        Route::resource('shippings', ShippingController::class);
        
        Route::get('/notification_device', [NotificationDeviceController::class, 'deviceDashboard'])->name('notification_device.dashboard');
        Route::get('/notification_device/data', [NotificationDeviceController::class, 'getData'])->name('notification_device.data');

        Route::get('/push_notifications/data', [PushNotificationController::class, 'getData'])->name('push_notifications.data');
        Route::resource('push_notifications', PushNotificationController::class);
        Route::post('/push_notifications/test', [PushNotificationController::class, 'sendTestPushNotification'])->name('push_notifications.test');
        
        Route::get('/vendor_payment/{vendor_id}/send_payment', [VendorPaymentController::class, 'sendPayment'])->name('vendor_payments.send_payment');
        Route::post('/vendor_payment/{vendor_id}/send_payment', [VendorPaymentController::class, 'store']);
        Route::get('/vendor_payment/{vendor_id}/send_pending_payment', [VendorPaymentController::class, 'sendPendingPayment'])->name('vendor_payments.send_pending_payment');
        Route::post('/vendor_payment/{vendor_id}/confirm', [VendorPaymentController::class, 'paymentConfirm'])->name('vendor_payments.payment_confirm');
        Route::resource('vendor_payments', VendorPaymentController::class);
        
        Route::get('/settings', [ResetPasswordController::class, 'showResetForm'])->name('admin.settings');

        Route::get('/home_page_product', [HomePageProductController::class, 'index'])->name('admin.home_page_product.index');
    });


    Route::post('/upload', [HomeController::class, 'upload'])->name('upload');

    Route::middleware(['cors'])->group(function () {
        Route::get('/log', [HomeController::class, 'log'])->name('log');
    });

    Auth::routes();
});
