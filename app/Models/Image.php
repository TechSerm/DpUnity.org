<?php

namespace App\Models;

use App\Services\Image\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name'
    ];

    public function service()
    {
        return new ImageService($this);
    }

    public function src()
    {
        return $this->service()->src();
    }
}
