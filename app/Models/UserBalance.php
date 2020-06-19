<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends AbstractBaseModel
{
    protected $fillable = [
        'balance',
        'balance_achieve',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userBalanceHistory()
    {
        return $this->hasOne(UserBalanceHistory::class);
    }
}
