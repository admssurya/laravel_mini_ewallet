<?php

use App\Constants\TypeConstant;
use App\Models\UserBalance;
use App\Models\UserBalanceHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserBalanceHistorySeeder extends Seeder
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
        $userBalances =  UserBalance::all();

        $userBalances->each(static function($userBalance, $key) use ($faker) {
           $userBalanceHistory = new UserBalanceHistory();
           $userBalanceHistory->userBalance()->associate($userBalance);
           $userBalanceHistory->balance_before = $faker->numberBetween($min = 1000, $max = 9999);
           $userBalanceHistory->balance_after = $faker->numberBetween($min = 1000, $max = 9999);
           $userBalanceHistory->activity = 'TOP UP';
           $userBalanceHistory->type = TypeConstant::CREDIT;
           $userBalanceHistory->ip = $faker->ipv4;
           $userBalanceHistory->location = $faker->latitude($min = -90, $max = 90).','.$faker->longitude($min = -180, $max = 180);
           $userBalanceHistory->user_agent = $faker->name;
           $userBalanceHistory->author = $faker->name;
           $userBalanceHistory->save();
        });
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('user_balance_histories')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
