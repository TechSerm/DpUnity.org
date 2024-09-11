<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'father_name',
        'mother_name',
        'date_of_birth',
        'nationality',
        'religion',
        'occupation',
        'present_address',
        'permanent_address',
        'nid',
        'mobile',
        'blood_group',
        'image_id',
        'signature_id',
        'user_id',
        'is_approved'
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'date_of_birth',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function signature()
    {
        return $this->belongsTo(Image::class, 'signature_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCoverPhotoAttribute()
    {
        $photos = [
            'cover_1.jpg',
            'cover_2.jpg',
            'cover_3.jpg',
            'cover_4.jpg',
            'cover_5.jpg',
            'cover_6.jpg',
            'cover_7.jpg',
            'cover_8.jpg',
            'cover_9.jpg',
            'cover_10.jpg',
            'cover_11.jpg',
        ];
        $position = ($this->id % count($photos)) + 1;
        return asset('assets/img/' . $photos[$position]);
    }
}
