<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active');
            $table->string('administrator')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('commercial_registration_no')->nullable();
            $table->string('tax_card')->nullable();
            $table->text('other')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shipping_companies_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipping_company_id')->unsigned();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('locale')->index();
            $table->timestamps();
            $table->unique(['shipping_company_id','locale'], 'unique_shipping_company');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_companies');
        Schema::dropIfExists('shipping_companies_translations');
    }
}
