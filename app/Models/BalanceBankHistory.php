<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceBankHistory extends AbstractBaseModel
{
    protected $fillable = [
        'balance_before',
        'balance_after',
        'activity',
        'type',
        'ip',
        'location',
        'user_agent',
        'author'
    ];

    public function balanceBank()
    {
        return $this->belongsTo(BalanceBank::class);
    }
}
