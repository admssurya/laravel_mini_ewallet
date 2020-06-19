<?php

use App\Models\BalanceBank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BalanceBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        factory(BalanceBank::class, 4)->create();
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('balance_banks')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
