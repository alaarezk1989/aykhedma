<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id')->after('branch_id')->nullable();
            $table->unsignedBigInteger('voucher_id')->after('coupon_id')->nullable();
            $table->unsignedBigInteger('discount_id')->after('voucher_id')->nullable();
            $table->double('final_amount')->after('discount_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon_id');
            $table->dropColumn('voucher_id');
            $table->dropColumn('discount_id');
            $table->dropColumn('final_amount');
        });
    }
}
