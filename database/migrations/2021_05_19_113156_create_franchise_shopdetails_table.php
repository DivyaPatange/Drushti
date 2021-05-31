<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranchiseShopdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_shopdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('franchise_id');
            $table->foreign('franchise_id')->references('id')->on('franchises');
            $table->string('shop_name')->nullable();
            $table->string('shop_registration_id')->nullable();
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
        Schema::dropIfExists('franchise_shopdetails');
    }
}
