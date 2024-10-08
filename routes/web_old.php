<?php

use App\Http\Controllers\AccountTransactionController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\DeliveryTransportCostController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomePageProductController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationDeviceController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderProfitDipositeController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchKeywordController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StoreCategoryController;
use App\Http\Controllers\StoreOrderController;
use App\Http\Controllers\TemporaryProductController;
use App\Http\Controllers\VendorPaymentController;
use App\Models\DeliveryTransportCost;
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

Route::middleware(['device_token_check', 'device_history', 'check_push_notification_click'])->group(function () {
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

    Route::get('/profile', [StoreController::class, 'profile'])->name('profile');

   // Route::post('/survey_form',  [StoreController::class, 'surveyFormSave'])->name('survey_form_save.store');

});

Auth::routes();

Route::get('/_images/{filename}', [ImageController::class, 'resize'])->name('image');
Route::get('/_export/{table_name}', [ExportController::class, 'exportCsv']);

Route::get('/print', [InvoiceController::class, 'index'])->name('invoice.index');
Route::get('/print/{order}', [InvoiceController::class, 'print'])->name('invoice.print');
Route::get('/product_name_suggestions', [ProductController::class, 'getSuggestionsProductName'])->name('product.name_suggestions');

Route::prefix('admin')->group(function () {

    Route::middleware(['auth','device_token_check','device_history', 'check_push_notification_click'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.home');

        //temporary products routes
        Route::get('/temporary_products/data', [TemporaryProductController::class, 'getData'])->name('temporary_products.data');
        Route::get('/temporary_products/{temporary_product}/confirm', [TemporaryProductController::class, 'showConfirm'])->name('temporary_products.confirm');
        Route::post('/temporary_products/{temporary_product}/confirm', [TemporaryProductController::class, 'confirm']);
        Route::resource('temporary_products', TemporaryProductController::class);

        //product routes
        Route::get('/products/offer', [ProductController::class, 'offer'])->name('products.offer');
        Route::get('/products/data', [ProductController::class, 'getData'])->name('products.data');
        Route::get('/products/order', [ProductController::class, 'getOrder'])->name('products.order');
        Route::post('/products/order', [ProductController::class, 'setOrder']);
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
        Route::get('/orders/{order}/history', [OrderController::class, 'history'])->name('orders.show.history');
        Route::post('/orders/{order}/change_order_status/{status}', [OrderController::class, 'changeOrderStatus'])->name('orders.status.change');
        Route::get('/orders/{order}/update_customer_details', [OrderController::class, 'showUpdateCustomer'])->name('orders.customer.update');
        Route::put('/orders/{order}/update_customer_details', [OrderController::class, 'updateCustomer']);
        Route::prefix('orders/{order}')->middleware(['order_show_page_check'])->group(function () {
            Route::put('/update_vendor', [OrderController::class, 'updateVendor']);
            Route::get('/product_select2_data', [OrderItemController::class, 'getProductSelect2Data'])->name('orders.order_items.product_select2_data');
            Route::get('/product_create_form', [OrderItemController::class, 'productCreateForm'])->name('orders.order_items.create_form');
            Route::get('/product_temp_create_form', [OrderItemController::class, 'productTempCreateForm'])->name('orders.order_items.temp_create_form');
            Route::post('/product_temp_create_form', [OrderItemController::class, 'storeProductTemp']);
            Route::resource('order_items', OrderItemController::class);
            Route::get('/assign_product_vendor_list', [OrderController::class, 'assignProductVendorList'])->name('orders.vendor.assign_product_vendor_list');
            Route::post('/assign_product_vendor_list', [OrderController::class, 'updateAssignProductVendorList']);
        });

        Route::get('/account_transaction', [AccountTransactionController::class, 'index'])->name('account_transaction.index');
        Route::get('/account_transaction/diposite', [AccountTransactionController::class, 'dipositeCreate'])->name('account_transaction.diposite');
        Route::post('/account_transaction/diposite', [AccountTransactionController::class, 'dipositeStore']);

        Route::get('/account_transaction/withdraw', [AccountTransactionController::class, 'withdrawCreate'])->name('account_transaction.withdraw');
        Route::post('/account_transaction/withdraw', [AccountTransactionController::class, 'withdrawStore']);

        //order profit diposite
        Route::post('/order_profit_diposites/{order_profit_diposite}/confirm', [OrderProfitDipositeController::class, 'confirm'])->name('order_profit_diposites.confirm');
        Route::resource('order_profit_diposites', OrderProfitDipositeController::class);

        Route::get('/orders/{order}/print', [OrderController::class, 'printOrder'])->name('orders.print');
        Route::resource('orders', OrderController::class);

        Route::resource('delivery_transport_costs', DeliveryTransportCostController::class);

        Route::get('/product_price', [ProductController::class, 'productPrice'])->name('product_price.index');
        Route::post('/product_price', [ProductController::class, 'productPriceUpdate']);

        Route::get('/search-keywords/data', [SearchKeywordController::class, 'getData'])->name('search-keywords.data');
        Route::resource('search-keywords', SearchKeywordController::class);

        Route::get('/shippings/data', [ShippingController::class, 'getData'])->name('shippings.data');
        Route::resource('shippings', ShippingController::class);

        Route::get('/notification_device', [NotificationDeviceController::class, 'deviceDashboard'])->name('notification_device.dashboard');
        Route::get('/notification_device/show/{notification_device_id}', [NotificationDeviceController::class, 'show'])->name('notification_device.show');
        Route::get('/notification_device/data', [NotificationDeviceController::class, 'getData'])->name('notification_device.data');

        Route::get('/push_notifications/data', [PushNotificationController::class, 'getData'])->name('push_notifications.data');
        Route::resource('push_notifications', PushNotificationController::class);
        Route::post('/push_notifications/test', [PushNotificationController::class, 'sendTestPushNotification'])->name('push_notifications.test');

        Route::get('/vendor_payment/{vendor_id}/send_payment', [VendorPaymentController::class, 'sendPayment'])->name('vendor_payments.send_payment');
        Route::post('/vendor_payment/{vendor_id}/send_payment', [VendorPaymentController::class, 'store']);
        Route::get('/vendor_payment/{vendor_id}/show_order/{order_id}', [VendorPaymentController::class, 'showOrder'])->name('vendor_payments.show_order');
        Route::get('/vendor_payment/{vendor_id}/send_pending_payment', [VendorPaymentController::class, 'sendPendingPayment'])->name('vendor_payments.send_pending_payment');
        Route::post('/vendor_payment/{vendor_id}/confirm', [VendorPaymentController::class, 'paymentConfirm'])->name('vendor_payments.payment_confirm');
        Route::resource('vendor_payments', VendorPaymentController::class);

        Route::get('/settings', [ResetPasswordController::class, 'showResetForm'])->name('admin.settings');

        Route::resource('customer_reviews', CustomerReviewController::class);
        Route::post('/customer_reviews/{customer_review}/add_review', [CustomerReviewController::class, 'enterMobile'])->name('customer_reviews.enter_mobile');
        Route::post('/customer_reviews/enter_mobile', [CustomerReviewController::class, 'enterMobile'])->name('customer_reviews.enter_mobile');
        Route::post('/customer_reviews/add_customer', [CustomerReviewController::class, 'addCustomer'])->name('customer_reviews.add_customer');

        Route::get('/home_page_product', [HomePageProductController::class, 'index'])->name('admin.home_page_product.index');
    });


    Route::post('/upload', [HomeController::class, 'upload'])->name('upload');

    Route::middleware(['cors'])->group(function () {
        Route::get('/log', [HomeController::class, 'log'])->name('log');
    });
    
    
});


