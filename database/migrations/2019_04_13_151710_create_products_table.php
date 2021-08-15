<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements("id") ;
            $table->unsignedBigInteger("unit_id");
            $table->string("unit_value","45")->nullable();
            $table->string("code",30)->nullable();
            $table->string("manufacturer")->nullable();
            $table->boolean("active")->default(1);
            $table->boolean("bundle")->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("products");
    }
}
