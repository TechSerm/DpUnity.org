<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDevice extends Model
{
    protected $fillable = [
        'token', 'last_visit_ip', 'last_visit_time', 'hits', 'last_visit_page'
    ];

    public function history()
    {
        return $this->hasMany(DeviceHistory::class, 'device_id');
    }
}
