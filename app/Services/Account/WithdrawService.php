<?php

namespace App\Services\Account;

use App\Models\AccountTransaction;

class WithdrawService
{
    public function create($title, $amount, $note = null)
    {
        $accountTransaction = new AccountTransaction();
        if (!$accountTransaction->isPossibleWithdraw($amount)) return [];

        $accountTransaction = AccountTransaction::create([
            'type' => 'withdraw',
            'title' => $title,
            'amount' => $amount,
            'note' => $note,
            'is_approved' => true,
            'user_id' => auth()->user()->id
        ]);

        return $accountTransaction;
    }
}
