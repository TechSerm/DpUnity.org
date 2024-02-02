<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'product_id',
        'attribute_id',
    ];

    public function getRouteKeyName()
    {
        return "uuid";
    }

    public function getNameAttribute()
    {
        return $this->attribute->name;
    }

    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
