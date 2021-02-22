<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Initial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('users')->create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50);
            $table->string('surname', 50);
            $table->string('email', 50);
            $table->string('address')->default('');
            $table->boolean('is_active')->default(true);
            $table->string('password');
            $table->string('token')->default('');
            $table->timestamp('created_at')->default('NOW()');
            $table->timestamp('updated_at')->default('NOW()');
        });

        Schema::connection('finance')->create('wallets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('wallet_key')->default('');
            $table->integer('balance')->default(0);
            $table->boolean('is_locked')->default(false);
            $table->uuid('locked_by_transaction')->nullable();
            $table->timestamp('created_at')->default('NOW()');
            $table->timestamp('updated_at')->default('NOW()');
        });

        Schema::connection('finance')->create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('wallet_from_id');
            $table->foreign('wallet_from_id')->references('id')->on('wallets');
            $table->uuid('wallet_to_id');
            $table->foreign('wallet_to_id')->references('id')->on('wallets');
            $table->integer('amount');
            $table->integer('commission_amount');
            $table->uuid('user_id');
            $table->timestamp('created_at')->default('NOW()');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('finance')->drop('transactions');
        Schema::connection('finance')->drop('wallets');
        Schema::connection('users')->drop('users');
    }
}
