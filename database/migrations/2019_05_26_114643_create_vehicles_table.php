<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type_id');
            $table->integer('status_id');
            $table->unsignedBigInteger('zone_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('shipping_company_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('capacity');
            $table->string('number');
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
        });
     Schema::create('vehicles_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('vehicle_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();
            $table->timestamps();
            $table->unique(['vehicle_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('vehicles_translations');
    }
}
