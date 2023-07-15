<?php

namespace App\Models;

use App\Services\PushNotification\PushNotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $fillable = [
        'uuid', 'title', 'body', 'url', 'image', 'is_scheduling_notification', 'scheduling_time', 'total_sends', 'is_complete_send'
    ];

    public function clicks()
    {
        return $this->hasMany(PushNotificationClick::class);
    }

    public function notifyAll()
    {
        return (new PushNotificationService())->notifyAll($this);
    }

    public function notifyAdmin()
    {
        return (new PushNotificationService())->notifyAdmin($this);
    }
}
