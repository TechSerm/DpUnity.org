<?php

namespace App\Services\Vendor;

use App\Models\User;

class VendorService
{
    public function getList()
    {
        return User::where(['role_name' => 'vendor'])->get();
    }
}
