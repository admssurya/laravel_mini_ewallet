<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBalanceHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_balance_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_balance_id');
            $table->integer('balance_before');
            $table->integer('balance_after');
            $table->string('activity');
            $table->enum('type', ['credit','debit']);
            $table->string('ip');
            $table->string('location');
            $table->string('user_agent');
            $table->string('author');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('user_balance_id')
                ->references('id')
                ->on('user_balances')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('user_balance_history');
    }
}
