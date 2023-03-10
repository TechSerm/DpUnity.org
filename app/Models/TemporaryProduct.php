<?php

namespace App\Models;

use App\Services\Image\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'unit',
        'price',
        'image_id',
        'wholesale_price',
        'market_sale_price',
        'profit',
        'vendor_id'
    ];

    public function getImageAttribute()
    {
        return $this->imageSrv()->src();
    }

    public function imageTable()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function imageSrv()
    {
        return new ImageService($this->imageTable);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
