<?php

namespace App\Services\Account;

use App\Enums\AccountTransactionEnum;

class DepositService extends AccountService
{
    /**
     * @param string $title
     * @param int $amount
     * @param string|null $note
     * @param int|null $userId
     * @return mixed
     */
    public function deposit(string $title, int $amount, string $note = null, int $userId = null) : mixed
    {
        return $this->addAccount(AccountTransactionEnum::DepositType, $title, $amount, $note, $userId);
    }

    public function manualDeposit($amount, $note)
    {
        return $this->deposit("manual", $amount, $note);
    }
}
