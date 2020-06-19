<?php


namespace App\Services;


use App\Models\BalanceBank;

class BalanceBankService extends AbstractBaseService
{
    public function __construct(BalanceBank $balanceBank)
    {
        $this->model = $balanceBank;
    }
}
