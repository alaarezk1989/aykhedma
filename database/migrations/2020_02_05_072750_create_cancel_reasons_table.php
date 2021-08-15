<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancel_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active');
            $table->timestamps();
        });

        Schema::create('cancel_reasons_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cancel_reason_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();
            $table->timestamps();
            $table->unique(['cancel_reason_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cancel_reasons');
        Schema::dropIfExists('cancel_reasons_translations');
    }
}
