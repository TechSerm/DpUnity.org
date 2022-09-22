<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchKeyword extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'key'
    ];

    public function values()
    {
        return $this->hasMany(SearchKeywordValue::class);
    }
}
