<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('settlement_id');
            $table->foreign('settlement_id')->references('id')->on('settlements');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('salary')->nullable();
            $table->string('balance')->nullable();
            $table->string('extra')->nullable();
            $table->string('adminwallet')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->enum('reason', ['Income', 'Salary']);
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
        Schema::dropIfExists('user_wallets');
    }
}
