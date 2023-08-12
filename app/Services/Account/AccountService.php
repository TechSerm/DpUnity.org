<?php

namespace App\Services\Account;
use App\Models\AccountTransaction;

class AccountService
{
    /**
     * @param string $type
     * @param string $title
     * @param int $amount
     * @param string|null $note
     * @param int|null $userId
     * @return mixed
     */
    protected function addAccount(string $type, string $title, int $amount, string $note = null, int $userId = null): mixed
    {
        return AccountTransaction::create([
            'type' => $type,
            'title' => $title,
            'amount' => $amount,
            'note' => $note,
            'is_approved' => true,
            'user_id' => $this->getUser($userId)
        ]);
    }

    /**
     * @param mixed $userId
     * @return mixed
     */
    protected function getUser(mixed $userId): mixed
    {
        return is_null($userId) ? auth()->user()->id : $userId;
    }

    /**
     * @param int $amount
     * @return bool
     */
    protected function isValidWithdrawAmount(int $amount): bool
    {
        $accountTransaction = new AccountTransaction();
        return $accountTransaction->isPossibleWithdraw($amount) || $amount < 0;
    }
}
