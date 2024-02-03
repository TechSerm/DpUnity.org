<?php

namespace App\Models;

use App\Cart\Cart;
use App\Services\Image\ImageService;
use App\Services\Search\SearchService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Woo\Models\WooProduct;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    protected $fillable = [
        'name',
        'quantity',
        'unit',
        'price',
        'image_id',
        'keyword',
        'status',
        'has_stock',
        'serial',

        'regular_price',
        'sale_price',
        'total_stock',
        'has_hot_deals',
        'description',
    ];

    public function getImageAttribute()
    {
        return $this->imageSrv()->src();
    }

    public function getShortNameAttribute()
    {
        $maxLength = 30;
        $text = $this->name;
        return mb_strlen($text, 'UTF-8') > $maxLength ? mb_substr($text, 0, $maxLength, 'UTF-8') . '...' : $text;
    }

    public function imageTable()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function imageSrv()
    {
        return new ImageService($this->imageTable);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function cartQuantity()
    {
        return Cart::quantity($this->id);
    }

    public function cartUpdate($quantity)
    {
        Cart::update($this->id, $quantity);
    }

    public function orders()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class)->with(['attribute.values']);
    }

    public function keyWordUpdate()
    {
        SearchService::createSearchKeyword($this->name);
    }
}
