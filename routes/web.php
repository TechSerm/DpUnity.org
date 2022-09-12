<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
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

Route::get('/', \App\Http\Livewire\Home::class)->name('home');
//Route::get('/', [StoreController::class, 'home'])->name('store.home');
Route::get('/home-products', [StoreController::class, 'homeProducts'])->name('store.home.products');

Route::get('/cart', \App\Http\Livewire\Cart\CartIndex::class)->name('cart');

Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::post('/order', [OrderController::class, 'create']);

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
        Route::get('/orders/{order}/update_customer_details', [OrderController::class, 'showUpdateCustomer'])->name('orders.customer.update');
        Route::put('/orders/{order}/update_customer_details', [OrderController::class, 'updateCustomer']);
        Route::resource('orders', OrderController::class);
    });


    Route::post('/upload', [HomeController::class, 'upload'])->name('upload');

    Route::middleware(['cors'])->group(function () {
        Route::get('/log', [HomeController::class, 'log'])->name('log');
    });

    Auth::routes();
});
