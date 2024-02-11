<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Services\Image\ImageService;


class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_id'
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

}
