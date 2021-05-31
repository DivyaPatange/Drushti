<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('settlement_id');
            $table->foreign('settlement_id')->references('id')->on('settlements');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('total');
            $table->date('from_date');
            $table->date('to_date');
            $table->boolean('settled_status')->default(0);
            $table->string('settled_date')->nullable();
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
        Schema::dropIfExists('payment_settlements');
    }
}
