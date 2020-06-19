<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceBank extends AbstractBaseModel
{
    protected $fillable = [
        'balance',
        'balance_achieve',
        'code',
        'enable'
    ];

}
