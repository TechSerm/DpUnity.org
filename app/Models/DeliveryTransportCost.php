<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTransportCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'amount',
        'date',
        'note',
        'user_id',
        'account_transaction_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accountTransaction()
    {
        return $this->belongsTo(AccountTransaction::class);
    }

    
}
