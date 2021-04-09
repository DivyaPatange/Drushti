<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranchisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchises', function (Blueprint $table) {
            $table->integer('id');
            $table->string('fullname');
            $table->string('username');
            $table->string('mobile');
            $table->string('nominee_name')->nullable();
            $table->string('email')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->date('reg_date')->nullable();
            $table->string('parent_id');
            $table->string('referral_code');
            $table->string('address')->nullable();
            $table->string('password');
            $table->string('password_1');
            $table->boolean('status')->default(0);
            $table->rememberToken();  
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
        Schema::dropIfExists('franchises');
    }
}
