<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponesTable extends Migration
{
    public function up()
    {
        Schema::create('coupones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("branch_id")->nullable();
            $table->unsignedBigInteger("vendor_id")->nullable();
            $table->unsignedBigInteger("activity_id")->nullable();
            $table->string("code")->unique();
            $table->integer("type");
            $table->integer("value");
            $table->integer("minimum_order_price");
            $table->boolean("active");
            $table->date('expire_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coupones_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('coupon_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['coupon_id','locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupones');
        Schema::dropIfExists('coupones_translations');
    }
}
