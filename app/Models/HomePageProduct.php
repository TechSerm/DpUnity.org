<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageProduct extends Model
{
    protected $fillable = [
        'product_id',
        'serial_no',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
