<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = "order_status";
    protected $fillable = [
        'uuid',
        'order_id',
        'name',
        'status',
    ];

    protected $appends = ['bn_name','en_name'];

    public function getBnNameAttribute()
    {
        return OrderStatusEnum::hasValue($this->name) ? OrderStatusEnum::fromValue($this->name)->bnName() : $this->name;
    }

    public function getenNameAttribute()
    {
        return OrderStatusEnum::hasValue($this->name) ? OrderStatusEnum::fromValue($this->name)->name() : $this->name;
    }
}
