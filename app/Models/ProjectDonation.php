<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Project;
use App\Models\Member;

class ProjectDonation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'mobile',
        'member_id',
        'amount',
        'when',
        'note',
        'user_id',
        'project_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'when' => 'datetime',
        'amount' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generate UUID if not provided
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
                $model->user_id = auth()->user()->id;
                $model->when = now();
            }
        });
    }

    /**
     * Relationship with User who recorded the donation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relationship with Member (optional)
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getTypeAttribute($value)
    {
        return $this->member ? 'member' : 'unknown';
    }

    public function getNameAttribute($value)
    {
        return $this->member ? $this->member->name : $value;
    }

    public function getMobileAttribute($value)
    {
        return $this->member ? $this->member->mobile : $value;
    }

    public function getMobileNumberMaskAttribute()
    {
        $mobile = $this->mobile;
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
