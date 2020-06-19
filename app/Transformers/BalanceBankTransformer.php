<?php

namespace App\Transformers;

use App\Models\BalanceBank;
use League\Fractal\TransformerAbstract;

class BalanceBankTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'balance_bank_history'
    ];

    /**
     * A Fractal transformer.
     *
     * @param BalanceBank $balanceBank
     * @return array
     */
    public function transform(BalanceBank $balanceBank)
    {
        return [
            'balance' => $balanceBank->balance,
            'balance_achieve' => $balanceBank->balance_achieve,
            'code' => $balanceBank->code,
            'enable' => $balanceBank->enable,
        ];
    }

    public function includeBalanceBankHistory(BalanceBank $balanceBank)
    {
        if ($balanceBank->balanceBankHistory) :
            return $this->item($balanceBank->balanceBankHistory, new BalanceBankHistoryTransformer());
        endif;
    }
}
