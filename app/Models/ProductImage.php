<?php

namespace App\Models;

use App\Services\Image\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'product_id',
        'image_id',
    ];

    public function getRouteKeyName(){
        return "uuid";
    }

    public function getImageAttribute()
    {
        return $this->imageSrv()->src();
    }

    public function getUrlAttribute()
    {
        return $this->image;
    }

    public function imageSrv()
    {
        return new ImageService($this->imageTable);
    }

    public function imageTable()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

}
