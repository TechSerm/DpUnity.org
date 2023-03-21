<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProfitDiposite extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'product_profit',
        'delivery_fee',
        'total_amount',
        'total_orders',

        'note',
        'user_id',
        'account_transaction_id',
        'is_approved'
    ];

    public function getRouteKeyName(){
        return "uuid";
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_profit_diposite_id');
    }
}
