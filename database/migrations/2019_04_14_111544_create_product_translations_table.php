<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("product_id");
            $table->string("name") ;
            $table->text("description") ;
            $table->text("meta_title")->nullable() ;
            $table->text("meta_description")->nullable() ;
            $table->text("meta_keyword")->nullable() ;
            $table->string('locale')->index();
            $table->timestamps();
            $table->softDeletes() ;
            $table->unique(["product_id", "locale"]) ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_translations');
    }
}
