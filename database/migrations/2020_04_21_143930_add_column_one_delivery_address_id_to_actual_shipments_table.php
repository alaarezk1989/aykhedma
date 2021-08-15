<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOneDeliveryAddressIdToActualShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actual_shipments', function (Blueprint $table) {
            $table->unsignedBigInteger('one_delivery_address_id')->after('one_address')->nullable();
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
            $table->dropColumn('one_delivery_address_id');
        });
    }
}
