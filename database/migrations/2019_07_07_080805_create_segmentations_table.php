<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSegmentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segmentations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('class')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('orders_category')->nullable();
            $table->unsignedBigInteger('orders_wish_list_category')->nullable();
            $table->float('orders_amount')->nullable();
            $table->integer('users_number')->nullable();
            $table->integer('weeks_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('segmentations_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('segmentation_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();
            $table->timestamps();
            $table->unique(['segmentation_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('segmentations');
        Schema::dropIfExists('segmentations_translations');
    }
}
