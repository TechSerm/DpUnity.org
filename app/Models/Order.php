<?php

namespace App\Models;

use App\Enums\OrderPaymentStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Facades\Order\OrderFacade;
use App\Services\Order\OrderActivityService;
use App\Services\Order\OrderNotificationService;
use App\Services\Order\OrderService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

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

        'status',
        'payment_status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class)->with(['product']);
    }

    public function getStatusAttribute($value)
    {
        $value = OrderStatusEnum::hasValue($value) ? $value : OrderStatusEnum::PROCESSING;
        return OrderStatusEnum::fromValue($value);
    }

    public function getPaymentStatusAttribute($value)
    {
        $value = OrderPaymentStatusEnum::hasValue($value) ? $value : OrderPaymentStatusEnum::DUE;
        return OrderPaymentStatusEnum::fromValue($value);
    }

    public function scopeProcessing()
    {
        return $this->where('status', OrderStatusEnum::PROCESSING);
    }

    public function isOrderStatusDisabled()
    {
        return $this->status == OrderStatusEnum::COMPLETED || $this->status == OrderStatusEnum::CANCELED;
    }

    public function addCookie()
    {
        OrderFacade::userOrder()->addOrderCookie($this);
    }

    public function updateTotalCalculation()
    {
        return OrderFacade::updateTotalCalculation($this);
    }

    public function getStatusColorAttribute()
    {
        return OrderStatusEnum::hasValue($this->status) ? OrderStatusEnum::fromValue($this->status)->color() : '#000000';
    }

    public function isEditable()
    {
        return !($this->is_delivery_complete == true || $this->is_cancelled);
    }
}
