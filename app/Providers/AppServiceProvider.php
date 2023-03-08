<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\OrderVendor;
use App\Models\VendorPayment;
use App\Observers\CategoryObserver;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use App\Observers\OrderStatusObserver;
use App\Observers\OrderVendorObserver;
use App\Observers\VendorPaymentObserver;
use App\Services\Permission\PermissionService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Order::observe(OrderObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        OrderStatus::observe(OrderStatusObserver::class);
        OrderVendor::observe(OrderVendorObserver::class);
        VendorPayment::observe(VendorPaymentObserver::class);

        (new PermissionService())->initGatePermission();

        //default pagination style
        Paginator::defaultView('vendor.pagination.bootstrap-4');
        Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-4');
    }
}
