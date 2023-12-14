<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'customer_id', 'order_id', 'assigned_by',
        'audio_filename', 'review_description',
        'schedule_time', 'schedule_note', 'is_pending', 'is_done', 'is_cancelled', 'cancellation_reason',
    ];

    protected $casts = [
        'schedule_time' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

}
