<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Facades\Order\OrderFacade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',

        'name',
        'phone',
        'address',
        'area',
        'ip_address',
        'user_agent',

        'discount_total',
        'delivery_fee',
        'subtotal',
        'total',
        'wholesale_total',
        'products_profit',
        'total_profit',

        'status',
        'is_approved',
        'is_delivery_complete',
        'is_vendor_payment_complete',
        'is_cancelled',

        'vendor_id',
        'delivery_man_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusList()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function updateTotalCalculation()
    {
        return OrderFacade::updateTotalCalculation($this);
    }

    public function getStatusBnNameAttribute()
    {
        return OrderStatusEnum::hasValue($this->status) ? OrderStatusEnum::fromValue($this->status)->bnName() : $this->status;
    }
}
