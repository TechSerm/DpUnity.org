<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Woo\Queue\WooQueueLib;

class WooQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'woo_id',
        'orm_model_id',
        'slug',
        'data',
        'method',
        'woo_model',
    ];


    public function release()
    {
        return (new WooQueueLib($this))->release();
    }
}
