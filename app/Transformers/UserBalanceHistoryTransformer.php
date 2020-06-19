<?php

namespace App\Transformers;

use App\Models\UserBalanceHistory;
use League\Fractal\TransformerAbstract;

class UserBalanceHistoryTransformer extends TransformerAbstract
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
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @param UserBalanceHistory $userBalanceHistory
     * @return array
     */
    public function transform(UserBalanceHistory $userBalanceHistory)
    {
        return [
            'id' => $userBalanceHistory->id,
            'user_balance_id' => $userBalanceHistory->user_balance_id,
            'balance_before' => $userBalanceHistory->balance_before,
            'balance_after' => $userBalanceHistory->balance_after,
            'activity' => $userBalanceHistory->activity,
            'type' => $userBalanceHistory->type,
            'ip' => $userBalanceHistory->ip,
            'location' => $userBalanceHistory->location,
            'user_agent' => $userBalanceHistory->user_agent,
            'author' => $userBalanceHistory->author
        ];
    }
}
