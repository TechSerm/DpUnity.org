<?php

namespace App\Models;

use App\Cart\Cart;
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
        'image',
        'wholesale_price',
        'market_sale_price',
        'wholesale_price_last_update',
        'profit',
        'temp_categories_id',
        'keyword',
        'status'
    ];

    public function getImageAttribute($value)
    {
        return $value ?? "https://bibisena.tserm.com/wp-content/uploads/woocommerce-placeholder.png";
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function cartQuantity(){
        return Cart::quantity($this->id);
    }

    public function cartUpdate($quantity){
        Cart::update($this->id, $quantity);
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
