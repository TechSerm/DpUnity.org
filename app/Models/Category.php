<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Woo\Models\WooCategory;

class Category extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'woo_id',
        'name',
        'image',
    ];


    public function woo(){
        return new WooCategory($this);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->logOnlyDirty($this->fillable);
        // Chain fluent methods for configuration options
    }
}
