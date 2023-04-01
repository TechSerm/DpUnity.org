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
        $permissions = config('bsenapermission');
        $this->buildPermissionArray($permissions);
        $this->defineGate($this->permissionList);
    }

    private function defineGate($permissions)
    {
        foreach ($permissions as $permissionName => $roles) {
            Gate::define($permissionName, function ($user) use ($roles) {
                return in_array($user->role_name, $roles);
            });
        }
    }

    private function buildPermissionArray($permissionArray, $permissionPrefix = '')
    {
        if ($this->isRoleArray($permissionArray)) {
            if ($permissionPrefix == '') return;
            if (!isset($this->permissionList[$permissionPrefix])) {
                $this->permissionList[$permissionPrefix] = $permissionArray;
            }

            return;
        }

        foreach ($permissionArray as $key => $value) {
            $newPermissionPrefix = $permissionPrefix;
            if (!is_int($key)) {
                $newPermissionPrefix .= ($permissionPrefix != '' ? '.' : '') . $key;
            }

            $this->buildPermissionArray($value, $newPermissionPrefix);
        }
    }

    private function isRoleArray($permissionArray)
    {
        foreach ($permissionArray as $key => $value) {
            if (is_array($value)) return false;
        }
        return true;
    }
}
