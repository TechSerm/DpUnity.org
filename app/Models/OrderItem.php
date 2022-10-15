<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'uuid',
        'order_id',
        'product_id',

        'name',
        'unit',
        'unit_quantity',
        'quantity',

        'price',
        'wholesale_price',
        'wholesale_price_total',
        'wholesale_price_update_time',
        'profit',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
