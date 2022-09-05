<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'woo_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_area',
        'customer_ip_address',
        'customer_user_agent',
        'order_date',
        'discount_total',
        'shipping_total',
        'total',
        'subtotal',
        'wholesale_total',
        'profit',
        'order_status',
        'shop_id',
        'delivery_man_id'
    ];

    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
