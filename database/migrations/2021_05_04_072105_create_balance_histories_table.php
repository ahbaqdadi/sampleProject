<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_histories', function (Blueprint $table) {
            $table->id()->startingValue(1000000);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'fk_balance_histories_user_id')
                ->on('users')
                ->references('id');
            $table->unsignedBigInteger('balance_id');
            $table->foreign('balance_id', 'fk_balances_balance_id')
                ->on('balances')
                ->references('id');
            $table->enum('type', ['deposit', 'withdraw'])->default('deposit');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_histories');
    }
}
