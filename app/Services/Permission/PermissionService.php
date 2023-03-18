<?php

namespace App\Services\Permission;

use Illuminate\Support\Facades\Gate;

class PermissionService
{
    private $permissionList = [];
    public function initGatePermission()
    {
        $this->dashboardPermission();
    }

    private function dashboardPermission()
    {
        $permissions = [

            //dashboard
            'dashboard.profit' => ['admin'],
            'dashboard.profit.all_status' => ['admin', 'vendor'],
            'dashboard.profit.cashier' => ['admin','cashier'],
            
            //products
            'products.index' => ['admin', 'vendor','cashier'],
            'products.create' => ['admin'],
            'products.edit' => ['admin', 'vendor'],
            'products.show' => ['admin', 'vendor'],
            'products.history' => ['admin'],
            'products.delete' => ['super_admin'],


            'products_price.index' => ['admin', 'vendor'],

            //categories
            'categories.index' => ['admin'],
            'categories.create' => ['admin'],
            'categories.edit' => ['admin'],
            'categories.history' => ['admin'],
            'categories.delete' => ['super_admin'],

            'active_orders.index' => ['admin','vendor'],
            'vendor_payment.index' => ['admin','vendor'],

        ];

        $this->defineGate($permissions);
    }


    private function defineGate($permissions)
    {
        foreach ($permissions as $permissionName => $roles) {
            Gate::define($permissionName, function ($user) use ($roles) {
                $isAdmin = in_array("admin", $roles) ? $user->isAdmin() : false;
                $isSuperAdmin = in_array("super_admin", $roles) ? $user->isSuperAdmin() : false;
                $vendor = in_array("vendor", $roles) ? $user->isVendor() : false;
                $cashier = in_array("cashier", $roles) ? $user->isCashier() : false;

                return $isAdmin | $isSuperAdmin | $vendor | $cashier;
            });
        }
    }
}
