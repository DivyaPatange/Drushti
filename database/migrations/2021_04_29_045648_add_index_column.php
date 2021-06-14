<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('index')->nullable();
            $table->string('side')->nullable();
            $table->string('sub_parent_id')->nullable();
            $table->string('sponsor_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('index');
            $table->dropColumn('side');
            $table->dropColumn('sub_parent_id');
            $table->dropColumn('sponsor_id');
        });
    }
}
