<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'ip',
        'cache_data',
        'url',
        'user_id',
    ];
}
