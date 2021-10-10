<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanColumnToProductPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_payments', function (Blueprint $table) {
            $table->string('plan')->after('referral_code')->default(10500);
        });

        Schema::table('user_incomes', function (Blueprint $table) {
            $table->string('plan')->default(10500);
        });

        Schema::table('rewards', function (Blueprint $table) {
            $table->string('plan')->default(10500);
        });

        Schema::table('settlements', function (Blueprint $table) {
            $table->string('plan')->default(10500);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_payments', function (Blueprint $table) {
            $table->dropColumn('plan');
        });

        Schema::table('user_incomes', function (Blueprint $table) {
            $table->dropColumn('plan');
        });

        Schema::table('rewards', function (Blueprint $table) {
            $table->dropColumn('plan');
        });

        Schema::table('settlements', function (Blueprint $table) {
            $table->dropColumn('plan');
        });

    }
}
