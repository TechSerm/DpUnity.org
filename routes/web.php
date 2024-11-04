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

Route::middleware([])->group(function () {
    Route::get('/',  [HomeController::class, 'index'])->name('home.index');
    Route::get('/about_us',  [HomeController::class, 'aboutUs'])->name('about_us');
    Route::get('/diposite',  [HomeController::class, 'diposite'])->name('diposite')->middleware('auth');
    Route::get('/profile',  [HomeController::class, 'profile'])->name('profile.index')->middleware('auth');
    Route::get('/members/create',  [HomeController::class, 'memberForm'])->name('members.create');
    Route::post('/members/store',  [MemberController::class, 'store'])->name('members.store');
    Route::get('/members',  [MemberController::class, 'category'])->name('members.index');
    Route::get('/members/{category}',  [MemberController::class, 'viewList'])->name('members.category');
    Route::get('/members/profile/{member}',  [MemberController::class, 'viewProfile'])->name('members.profile');
});

Auth::routes();

Route::get('/_images/{filename}', [ImageController::class, 'resize'])->name('image');
//Route::get('/_export/{table_name}', [ExportController::class, 'exportCsv']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth', 'check_admin'])->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('home.index');

        Route::post('/ckeditor_upload', [CkEditorController::class, 'upload'])->name('ckeditor.upload');
        Route::get('/settings', [ResetPasswordController::class, 'showResetForm'])->name('settings');

        Route::get('admin_users/data', [UserController::class, 'getAdminData'])->name('admin_users.data');
        Route::get('normal_users/data', [UserController::class, 'getNormalUserData'])->name('normal_users.data');
        Route::get('normal_users', [UserController::class, 'normalUser'])->name('normal_users');
        Route::resource('users', UserController::class);
        Route::get('members/data', [MemberController::class, 'MemberData'])->name('members.data');
        Route::resource('members', MemberController::class);
        Route::prefix('transaction')->name('transaction.')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('index');
            Route::get('/diposite', [TransactionController::class, 'diposite'])->name('diposite.index');
            Route::get('/diposite/data', [TransactionController::class, 'dipositeData'])->name('diposite.data');
            Route::get('/diposite/create', [TransactionController::class, 'dipositeCreate'])->name('diposite.create');
            Route::post('/diposite/store', [TransactionController::class, 'dipositeStore'])->name('diposite.store');
            Route::get('/withdraw', [TransactionController::class, 'withdraw'])->name('withdraw.index');
            Route::get('/withdraw/create', [TransactionController::class, 'withdrawCreate'])->name('withdraw.create');
            Route::post('/withdraw/store', [TransactionController::class, 'withdrawStore'])->name('withdraw.store');
        });

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
    });


    Route::post('/upload', [HomeController::class, 'upload'])->name('upload');

    Route::middleware(['cors'])->group(function () {
        Route::get('/log', [HomeController::class, 'log'])->name('log');
    });
});
