<?php

/** @var Factory $factory */

use App\Models\BalanceBank;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(BalanceBank::class, function (Faker $faker) {
    return [
        'balance' => $faker->numberBetween($min = 1000, $max = 99999),
        'balance_achieve' => $faker->numberBetween($min = 1000, $max = 99999),
        'code' => 'MANDIRI',
        'enable' => $faker->boolean
    ];
});
