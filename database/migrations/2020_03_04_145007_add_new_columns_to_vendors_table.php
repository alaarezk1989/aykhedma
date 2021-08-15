<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('administrator')->nullable()->after('activity_id');
            $table->string('mobile')->nullable()->after('administrator');
            $table->string('phone')->nullable()->after('mobile');
            $table->string('email')->nullable()->after('phone');
            $table->integer('commercial_registration_no')->nullable()->after('email');
            $table->integer('tax_card')->nullable()->after('commercial_registration_no');
            $table->text('other')->nullable()->after('tax_card');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
