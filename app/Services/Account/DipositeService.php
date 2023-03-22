<?php

namespace App\Services\Account;

use App\Models\AccountTransaction;

class DipositeService
{
    public function create($title, $amount, $note = null, $userId = null)
    {
        $accountTransaction = AccountTransaction::create([
            'type' => 'diposite',
            'title' => $title,
            'amount' => $amount,
            'note' => $note,
            'is_approved' => true,
            'user_id' => is_null($userId) ? auth()->user()->id : $userId 
        ]);

        return $accountTransaction;
    }
}
