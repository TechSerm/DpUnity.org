<?php

namespace App\Services\Account;

use App\Models\AccountTransaction;

class DipositeService
{
    public function create($title, $amount, $note = null)
    {
        $accountTransaction = AccountTransaction::create([
            'type' => 'diposite',
            'title' => $title,
            'amount' => $amount,
            'note' => $note,
            'is_approved' => true,
            'user_id' => auth()->user()->id
        ]);

        return $accountTransaction;
    }
}
