<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'quantity',
        'price',
        'wholesale_price',
        'wholesale_price_last_update',
        'profit',
        'total',
        'unit_quantity',
        'unit'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
