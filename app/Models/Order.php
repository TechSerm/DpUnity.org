<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Facades\Order\OrderFacade;
use App\Services\Order\OrderNotificationService;
use App\Services\Order\OrderService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use HasFactory;
    use LogsActivity;

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
        'delivery_man_id',

        'device_token',
        'app_version',

        'is_vendor_assign',
        'is_pack_complete',
        'is_delivery_start'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class)->with(['product', 'vendor']);
    }

    public function addCookie()
    {
        OrderFacade::userOrder()->addOrderCookie($this);
    }

    public function statusList()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function vendors()
    {
        return $this->hasMany(OrderVendor::class)->with('user');
    }

    public function updateTotalCalculation()
    {
        return OrderFacade::updateTotalCalculation($this);
    }

    public function getStatusBnNameAttribute()
    {
        return OrderStatusEnum::hasValue($this->status) ? OrderStatusEnum::fromValue($this->status)->bnName() : $this->status;
    }

    public function getCustomerStatusAttribute()
    {
        return OrderStatusEnum::hasValue($this->status) ? OrderStatusEnum::fromValue($this->status)->customerStatus() : $this->status;
    }

    public function getStatusColorAttribute()
    {
        return OrderStatusEnum::hasValue($this->status) ? OrderStatusEnum::fromValue($this->status)->color() : '#000000';
    }

    public function getNotificationMessageAttribute()
    {
        return OrderStatusEnum::hasValue($this->status) ? OrderStatusEnum::fromValue($this->status)->notificationMessage() : $this->status;
    }


    public function isEditable()
    {
        return !($this->is_delivery_complete == true || $this->is_cancelled || auth()->user()->isVendor());
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function updateVendor()
    {
        return OrderFacade::updateOrderVendor($this);
    }

    public function notify()
    {
        return new OrderNotificationService($this);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([]);
    }
}
