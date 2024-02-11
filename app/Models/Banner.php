<?php

namespace App\Models;

use App\Services\Image\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'image_id',
        'serial',
    ];

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
