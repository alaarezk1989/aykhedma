<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToDriverOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_orders', function (Blueprint $table) {
            $table->string('start_location')->nullable();
            $table->string('end_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver_orders', function (Blueprint $table) {
            $table->dropColumn('start_location');
            $table->dropColumn('end_location');
        });
    }
}
