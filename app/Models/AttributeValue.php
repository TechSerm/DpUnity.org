<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'attribute_id',
    ];

    public function getRouteKeyName(){
        return "uuid";
    }
}
