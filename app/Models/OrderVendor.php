<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderVendor extends Model
{
    protected $fillable = [
        'uuid',
        'order_id',
        'vendor_id',

        'total',
        'wholesale_total',
        'profit',

        'is_received',
        'is_pack_complete',
        'is_vendor_payment_complete',
        'vendor_payment_id',
        'is_vendor_payment_send'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
