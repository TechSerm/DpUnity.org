<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Services\Image\ImageService;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_name',
        'phone',
        'remember_token',
    ];

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


    public function isAdmin()
    {
        return $this->role_name == 'admin' || $this->role_name == 'super_admin';
    }

    public function isSuperAdmin()
    {
        return $this->role_name == 'super_admin';
    }

    

    public function getImageAttribute()
    {
        return $this->imageSrv()->src();
    }

    public function member()
    {
        return Member::where('user_id', $this->id)->first();
    }

    public function imageTable()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function imageSrv()
    {
        return new ImageService($this->imageTable);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
}
