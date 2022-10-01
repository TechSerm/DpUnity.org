<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotificationClick extends Model
{
    protected $fillable = [
        'push_notification_id', 'ip'
    ];
}
