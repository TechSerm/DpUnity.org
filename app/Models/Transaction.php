<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'type',
        'name',
        'mobile',
        'member_id',
        'amount',
        'when',
        'note',
        'user_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->when = Carbon::now();
            $model->user_id = auth()->user()->id;
        });
    }

    // The attributes that should be cast to native types
    protected $casts = [
        'when' => 'datetime',
    ];

    public function scopeWithdraw($query)
    {
        return $query->where('type', 'withdraw');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeDiposite($query)
    {
        return $query->where('type', 'diposite');
    }

    function mobileNumberMask()
    {
        $mobile = $this->member ? $this->member->mobile : $this->mobile;
        // Check if the mobile number is valid
        if (strlen($mobile) < 5) {
            return 'Invalid mobile number';
        }

        // Get the first 2 digits and the last 3 digits
        $firstPart = substr($mobile, 0, 2);
        $lastPart = substr($mobile, -3);

        // Generate the masked middle section with asterisks
        $maskedMiddle = str_repeat('*', strlen($mobile) - 5);

        // Combine the parts
        return $firstPart . $maskedMiddle . $lastPart;
    }
}
