<?php

namespace App\Models;

use App\Services\Image\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'uuid',
        'title',
        'image_id',
        'serial',
    ];

    public function scopeSerialOrder() {
        return $this->orderBy('serial');
    }

    public function getImageAttribute()
    {
        return $this->imageSrv()->src();
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
