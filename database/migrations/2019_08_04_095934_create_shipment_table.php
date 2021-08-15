<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nestedSet();
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');
            $table->integer('capacity');
            $table->integer('recurring');
            $table->integer('load')->default(0);
            $table->integer('vehicle_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->integer('cut_off_date')->nullable();
            $table->dateTime('last_touch')->nullable();
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('shipment_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipment_id')->references('id')->on('shipments')->onDelete('cascade')->nullable();
            $table->string('title');
            $table->string('locale')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['shipment_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('shipment_translations');
    }
}
