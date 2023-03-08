<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'user_id',
        'vendor_id',

        'total',
        'total_orders',
        'notes',
        'is_vendor_received'
    ];

    public function getRouteKeyName(){
        return "uuid";
    }

    public function orders()
    {
        return $this->hasMany(OrderVendor::class, 'vendor_payment_id')->with('user','order');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
