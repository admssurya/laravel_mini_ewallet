<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBalanceHistory extends AbstractBaseModel
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

    public function userBalance()
    {
        return $this->belongsTo(UserBalance::class);
    }
}
