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
        'delivery_fee',
        'status',
        'has_stock',
        'vendor_id',
        'serial'
    ];

    protected $casts = [
        'wholesale_price_last_update' => 'datetime',
    ];

    public function getImageAttribute()
    {
        return $this->imageSrv()->response();
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

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
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
        $fillable = array_diff($this->fillable, ['serial']);

        return LogOptions::defaults()
            ->logOnly($fillable)
            ->dontLogIfAttributesChangedOnly(['serial'])
            ->logOnlyDirty($fillable);
    }
}
