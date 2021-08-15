<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('units_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->string('name');
            $table->string('acronym')->nullable();
            $table->string('locale')->index();
            $table->timestamps();
            $table->unique(['unit_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
        Schema::dropIfExists('units_translations');
    }
}
