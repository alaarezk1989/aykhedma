<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('administrator')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('commercial_registration_no')->nullable();
            $table->string('tax_card')->nullable();
            $table->text('other')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('companies_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('activity')->nullable();
            $table->string('locale')->index();
            $table->timestamps();
            $table->unique(['company_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('companies_translations');
    }
}
