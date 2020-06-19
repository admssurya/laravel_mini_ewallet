<?php

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        $faker = Faker\Factory::create();
        $users = collect(User::all());

        $users->each(static function($user, $key) use ($faker){
            $userBalance = new UserBalance();
            $userBalance->balance = $faker->randomNumber($nbDigits = 4, $strict = false);
            $userBalance->balance_achieve = $faker->numberBetween($min = 1000, $max = 9999);
            $userBalance->user()->associate($user);
            $userBalance->save();
        });
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('user_balances')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
