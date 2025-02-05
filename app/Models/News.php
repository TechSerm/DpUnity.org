<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'author',
        'published_at',
        'order',
        'is_featured',
        'status',
        'views',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'views' => 'integer',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug if not provided
        static::creating(function ($news) {
            $news->slug = $news->slug ?? Str::slug($news->title);
            $news->author = auth()->user()->id;
            $news->order = 1;
            DB::statement('UPDATE news SET `order` = `order` + 1 WHERE `order` >= 1');
        });
    }

    /**
     * Relationship with the Author (assuming it's a User model)
     */
    public function authorUser()
    {
        return $this->belongsTo(User::class, 'author');
    }

    /**
     * Scope a query to only include published news.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured news.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }


    public function getThumbnailUrlAttribute()
    {
        // Check if thumbnail exists and is not empty
        
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return asset('storage/' . $this->thumbnail);
        }
        
        // Return default image if no thumbnail
        return asset('assets/img/default_vlog_thumbnail.png');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
