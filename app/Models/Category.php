<?php

namespace App\Models;

use App\Services\Image\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Woo\Models\WooCategory;

class Category extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'name',
        'image_id',
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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->logOnlyDirty($this->fillable);
        // Chain fluent methods for configuration options
    }
}
