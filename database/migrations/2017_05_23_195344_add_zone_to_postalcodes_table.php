<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZoneToPostalcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postalcodes', function (Blueprint $table) {
            $table->string('precinct');
            $table->string('zone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postalcodes', function (Blueprint $table) {
            $table->dropColumn('precinct');
            $table->dropColumn('zone');
        });
    }
}
