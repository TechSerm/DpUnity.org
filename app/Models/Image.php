<?php

namespace App\Models;

use App\Helpers\Constant;
use App\Services\Image\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name'
    ];

    public function publicPath()
    {
        return public_path($this->getImagePath());
    }

    public function getImagePath()
    {
        return Constant::IMAGE_DIR . $this->name;
    }

    public function service()
    {
        return new ImageService($this);
    }

    public function src()
    {
        return $this->service()->src();
    }
}
