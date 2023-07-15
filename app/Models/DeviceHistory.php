<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'ip',
        'cache_data',
        'url',
        'user_id',
    ];

    public function shortUrl()
    {
        return $this->makeShortUrl($this->url);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    private function makeShortUrl($url)
    {
        $parsedUrl = parse_url($url);

        $path = '';
        if (isset($parsedUrl['path'])) {
            $path = ltrim($parsedUrl['path'], '/');
        }

        $query = '';
        if (isset($parsedUrl['query'])) {
            $query = '?' . $parsedUrl['query'];
        }

        $outputUrl = $path . $query;

        if (strlen($outputUrl) > 50) {
            $length = 50;
            $overflow = strlen($outputUrl) - $length;
            $trimLength = ($length - $overflow) / 2;

            $path = substr($path, 0, $trimLength) . '...' . substr($path, -$trimLength);
            $outputUrl = $path . $query;
        }

        return $outputUrl;
    }
}
