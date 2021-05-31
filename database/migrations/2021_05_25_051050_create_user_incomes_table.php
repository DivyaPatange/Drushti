<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('child_id');
            $table->string('level');
            $table->string('product_amount');
            $table->date('payment_date');
            $table->string('income_amount')->nullable();
            $table->string('admin_charges')->nullable();
            $table->string('net_income')->nullable();
            $table->boolean('settled_status')->default(0);
            $table->string('settled_date')->nullable();
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
        Schema::dropIfExists('user_incomes');
    }
}
