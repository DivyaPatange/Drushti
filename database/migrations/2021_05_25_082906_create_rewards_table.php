<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('level');
            $table->integer('total_joiner');
            $table->integer('joiner_added');
            $table->decimal('reward', 20);
            $table->decimal('reward_amt', 20);
            $table->decimal('admin_charges', 20);
            $table->decimal('net_income', 20);
            $table->enum('status', ['Qualified', 'Not Qualified']);
            $table->date('date')->nullable();
            $table->boolean('verified')->default(0);
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
        Schema::dropIfExists('rewards');
    }
}
