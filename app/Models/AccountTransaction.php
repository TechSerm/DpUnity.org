<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'amount',
        'type',
        'title',
        'note',
        'user_id',
        'is_approved',
    ];

    public function diposites()
    {
        return $this->where(['type' => 'diposite']);
    }

    public function withdraws()
    {
        return $this->where(['type' => 'withdraw']);
    }

    public function totalDiposite()
    {
        return $this->diposites()->sum('amount');
    }

    public function totalWithdraw()
    {
        return $this->withdraws()->sum('amount');
    }

    public function totalBalance()
    {
        return $this->totalDiposite() - $this->totalWithdraw();
    }

    public function isPossibleWithdraw($amount)
    {
        return $this->totalBalance() >= $amount;
    }
}
