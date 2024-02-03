<?php

namespace App\Models;

use App\Services\Image\ImageService;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
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
}
