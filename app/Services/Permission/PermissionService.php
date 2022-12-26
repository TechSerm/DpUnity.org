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
            
            //products
            'products.index' => ['admin', 'vendor'],
            'products.create' => ['admin'],
            'products.edit' => ['admin', 'vendor'],
            'products.show' => ['admin', 'vendor'],
            'products.history' => ['admin'],
            'products.delete' => ['super_admin'],

            //categories
            'categories.index' => ['admin'],
            'categories.create' => ['admin'],
            'categories.edit' => ['admin'],
            'categories.history' => ['admin'],
            'categories.delete' => ['super_admin'],

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

                return $isAdmin | $isSuperAdmin | $vendor;
            });
        }
    }
}
