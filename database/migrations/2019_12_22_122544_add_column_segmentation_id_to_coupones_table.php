<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSegmentationIdToCouponesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupones', function (Blueprint $table) {
            $table->unsignedBigInteger('segmentation_id')->after('expire_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupones', function (Blueprint $table) {
            $table->dropColumn('segmentation_id');
        });
    }
}
