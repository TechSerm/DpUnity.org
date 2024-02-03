<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'product_attribute_id',
        'attribute_value_id',
    ];

    public function getRouteKeyName()
    {
        return "uuid";
    }

    public function getNameAttribute()
    {
        return $this->value->name;
    }

    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }
}
