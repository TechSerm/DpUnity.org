<?php

use App\Http\Controllers\AccountTransactionController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\ImageController;

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StoreCategoryController;
use App\Http\Controllers\StoreOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CkEditorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
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

// Public Routes
Route::middleware([])->group(function () {
    // Home and Static Pages
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/about_us', [HomeController::class, 'aboutUs'])->name('about_us');
    Route::get('/news', [HomeController::class, 'newsList'])->name('news.index');
    Route::get('/news/{news}', [HomeController::class, 'showNews'])->name('news.show');

    // Members Management
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/', [MemberController::class, 'category'])->name('index');
        Route::get('/{category}', [MemberController::class, 'viewList'])->name('category');
        Route::get('/profile/{member}', [MemberController::class, 'viewProfile'])->name('profile');
    });

    // Image Handling
    Route::get('/_images/{filename}', [ImageController::class, 'resize'])->name('image');
});

// Authentication Required Routes
Route::middleware(['auth'])->group(function () {
    // Profile and Deposit
    Route::get('/diposite', [HomeController::class, 'diposite'])->name('diposite');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile.index');
    
    // Logout Route
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

    // Members Management
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/create', [HomeController::class, 'memberForm'])->name('create');
        Route::post('/store', [MemberController::class, 'store'])->name('store');
    });

    // Projects Management
    Route::resource('projects', ProjectController::class)->only(['index', 'show']);
    Route::prefix('projects/{project}')->name('projects.')->group(function () {
        Route::get('donations', [ProjectController::class, 'showDonations'])->name('donations');
        Route::get('expenses', [ProjectController::class, 'showExpenses'])->name('expenses');
        Route::get('details', [ProjectController::class, 'showDetails'])->name('details');
        Route::get('reports', [ProjectController::class, 'showReports'])->name('reports');
        Route::get('expenses/{expense}', [ProjectController::class, 'showExpenseDetails'])->name('expense_details');
    });
});

// Laravel's built-in authentication routes
Auth::routes();
