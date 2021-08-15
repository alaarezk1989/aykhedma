<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToActualShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actual_shipments', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->after('load')->nullable();
            $table->unsignedBigInteger('driver_id')->after('vehicle_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actual_shipments', function (Blueprint $table) {
            $table->dropColumn('vehicle_id');
            $table->dropColumn('driver_id');
        });
    }
}
