<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->nullable();
            $table->string('fullname')->nullable();
            $table->string('username')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('referral_code')->nullable();
            $table->text('address')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('password')->nullable();
            $table->string('password_1')->nullable();
            $table->date('reg_date')->nullable();
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
        Schema::dropIfExists('users');
    }
}
