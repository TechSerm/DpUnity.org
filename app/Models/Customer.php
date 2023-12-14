<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'uuid', 'mobile', 'name', 'address', 'note', 'is_active',
    ];

    public function reviews()
    {
        return $this->hasMany(CustomerReview::class, 'customer_id');
    }
}
