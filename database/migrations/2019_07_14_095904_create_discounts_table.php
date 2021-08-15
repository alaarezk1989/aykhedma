<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('activity_id')->references('id')->on('activities')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('vendor_id')->references('id')->on('vendors')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('branch_id')->references('id')->on('branches')->onDelete('cascade')->nullable();
            $table->double('value');
            $table->boolean('type');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->double('minimum_order_price')->nullable()->default(0);
            $table->integer('usage_no')->nullable()->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('discounts_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('discount_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['discount_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('discounts_translations');
    }
}
