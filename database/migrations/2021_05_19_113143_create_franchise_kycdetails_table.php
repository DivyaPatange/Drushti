<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranchiseKycdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_kycdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('franchise_id');
            $table->foreign('franchise_id')->references('id')->on('franchises');
            $table->string('pan_no')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->string('user_img')->nullable();
            $table->string('pan')->nullable();
            $table->string('cheque')->nullable();
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
        Schema::dropIfExists('franchise_kycdetails');
    }
}
