<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToShippingCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            $table->string('administrator_phone')->nullable()->after('administrator');
            $table->string('administrator_email')->nullable()->after('administrator_phone');
            $table->string('administrator_job')->nullable()->after('administrator_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            $table->dropColumn('administrator_phone');
            $table->dropColumn('administrator_email');
            $table->dropColumn('administrator_job');
        });
    }
}
