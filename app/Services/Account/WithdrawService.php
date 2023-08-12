<?php

namespace App\Services\Account;

use App\Enums\AccountTransactionEnum;
use App\Models\AccountTransaction;

class WithdrawService extends AccountService
{
    /**
     * @param string $title
     * @param int $amount
     * @param string|null $note
     * @param int|null $userId
     * @return mixed
     */
    public function withdraw(string $title, int $amount, string $note = null, int $userId = null) : mixed
    {
        if (!$this->isValidWithdrawAmount($amount)) return null;

        return $this->addAccount(AccountTransactionEnum::WithdrawType, $title, $amount, $note, $userId);
    }
}
