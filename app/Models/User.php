<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Services\Image\ImageService;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isVendor()
    {
        return $this->role_name == 'vendor';
    }

    public function isAdmin()
    {
        return $this->role_name == 'admin' || $this->role_name == 'super_admin';
    }

    public function isSuperAdmin()
    {
        return $this->role_name == 'super_admin';
    }

    public function isCashier()
    {
        return $this->role_name == 'cashier';
    }

    public function isDeliveryMan()
    {
        return $this->role_name == 'delivery_man';
    }

    public function imageTable()
    {
        return $this->belongsTo(Image::class,'image_id');
    }

    public function imageSrv()
    {
        return new ImageService($this->imageTable);
    }
}
