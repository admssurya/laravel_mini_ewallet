<?php

use App\Constants\TypeConstant;
use App\Models\BalanceBank;
use App\Models\BalanceBankHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BalanceBankHistorySeeder extends Seeder
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

        $balanceBanks = BalanceBank::all();

        $balanceBanks->each(static function($balanceBank, $key) use ($faker) {
           $balanceBankHistory = new BalanceBankHistory();
            $balanceBankHistory->balanceBank()->associate($balanceBank);
            $balanceBankHistory->balance_before = $faker->numberBetween($min = 1000, $max = 9999);
            $balanceBankHistory->balance_after = $faker->numberBetween($min = 1000, $max = 9999);
            $balanceBankHistory->activity = 'TOP UP';
            $balanceBankHistory->type = TypeConstant::CREDIT;
            $balanceBankHistory->ip = $faker->ipv4;
            $balanceBankHistory->location = $faker->latitude($min = -90, $max = 90).','.$faker->longitude($min = -180, $max = 180);
            $balanceBankHistory->user_agent = $faker->name;
            $balanceBankHistory->author = $faker->name;
            $balanceBankHistory->save();
        });
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('balance_bank_histories')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
