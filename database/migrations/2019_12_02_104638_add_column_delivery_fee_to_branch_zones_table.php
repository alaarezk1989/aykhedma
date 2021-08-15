<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDeliveryFeeToBranchZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch_zones', function (Blueprint $table) {
            $table->float('delivery_fee')->after('delivery_sla')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_zones', function (Blueprint $table) {
            $table->dropColumn('delivery_fee');
        });
    }
}
