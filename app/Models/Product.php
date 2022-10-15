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
    use LogsActivity;

    protected $fillable = [
        'woo_id',
        'name',
        'quantity',
        'unit',
        'price',
        'image_id',
        'wholesale_price',
        'market_sale_price',
        'wholesale_price_last_update',
        'profit',
        'temp_categories_id',
        'keyword',
        'status'
    ];

    public function getImageAttribute()
    {
        return $this->imageSrv()->src();
    }

    public function imageTable()
    {
        return $this->belongsTo(Image::class,'image_id');
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

    public function keyWordUpdate()
    {
        SearchService::createSearchKeyword($this->name);
    }

    public function woo()
    {
        return new WooProduct($this);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty($this->fillable);
    }
}
