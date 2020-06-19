<?php

namespace App\Transformers;

use App\Models\UserBalance;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class UserBalanceTransformer extends TransformerAbstract
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
        'user_balance_history'
    ];

    /**
     * A Fractal transformer.
     *
     * @param UserBalance $userBalance
     * @return array
     */
    public function transform(UserBalance $userBalance)
    {
        return [
            'id' => $userBalance->id,
            'user_id' => $userBalance->user_id,
            'balance' => $userBalance->balance,
            'balance_achieve' => $userBalance->balance_achieve
        ];
    }

    /**
     * @param UserBalance $userBalance
     * @return Item
     */
    public function includeUserBalanceHistory(UserBalance $userBalance)
    {
        if ($userBalance->userBalanceHistory) :
            return $this->item($userBalance->userBalanceHistory, new UserBalanceHistoryTransformer());
        endif;
    }
}
