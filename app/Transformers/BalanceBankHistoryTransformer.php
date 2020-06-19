<?php

namespace App\Transformers;

use App\Models\BalanceBankHistory;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class BalanceBankHistoryTransformer extends TransformerAbstract
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
    ];

    /**
     * A Fractal transformer.
     *
     * @param BalanceBankHistory $balanceBankHistory
     * @return array
     */
    public function transform(BalanceBankHistory $balanceBankHistory)
    {
        return [
            'balance_before' => $balanceBankHistory->balance_before,
            'balance_after' => $balanceBankHistory->balance_after,
            'activity' => $balanceBankHistory->activity,
            'type' => $balanceBankHistory->type,
            'ip' => $balanceBankHistory->ip,
            'location' => $balanceBankHistory->location,
            'user_agent' => $balanceBankHistory->user_agent,
            'author' => $balanceBankHistory->author
        ];
    }
}
