<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActualShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_shipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shipment_id')->nullable();
            $table->nestedSet();
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');
            $table->dateTime('cutoff')->nullable();
            $table->dateTime('from_time');
            $table->dateTime('to_time');
            $table->integer('capacity');
            $table->integer('load')->default(0);
            $table->integer('status')->nullable();
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('actual_shipments_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('actual_shipment_id')->references('id')->on('actual_shipments')->onDelete('cascade')->nullable();
            $table->string('title');
            $table->string('locale')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['actual_shipment_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actual_shipments');
        Schema::dropIfExists('actual_shipments_translations');
    }
}
