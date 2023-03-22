<?php

namespace App\Services\Account;

use App\Models\AccountTransaction;

class WithdrawService
{
    public function create($title, $amount, $note = null, $userId = null)
    {
        $accountTransaction = new AccountTransaction();
        if (!$accountTransaction->isPossibleWithdraw($amount) || $amount < 0) return [];

        $accountTransaction = AccountTransaction::create([
            'type' => 'withdraw',
            'title' => $title,
            'amount' => $amount,
            'note' => $note,
            'is_approved' => true,
            'user_id' => is_null($userId) ? auth()->user()->id : $userId 
        ]);

        return $accountTransaction;
    }
}
