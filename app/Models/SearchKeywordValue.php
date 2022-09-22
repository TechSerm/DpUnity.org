<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchKeywordValue extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'search_keyword_id',
        'value'
    ];

    public function key()
    {
        return $this->belongsTo(SearchKeyword::class);
    }
}
