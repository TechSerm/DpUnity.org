<?php

namespace App\Providers;

use App\Models\Image;
use App\Observers\ImageObserver;

use Illuminate\Pagination\Paginator;
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
        Image::observe(ImageObserver::class);
        
       // (new PermissionService())->initGatePermission();

        //default pagination style
        Paginator::defaultView('vendor.pagination.bootstrap-4');
        Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-4');
    }
}
