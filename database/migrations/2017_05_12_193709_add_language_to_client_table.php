<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLanguageToClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('language');// 1-eng , 2-mand, 3
            $table->string('notes');
            $table->string('preferred');//1-mobile, 2-office, 3-home, 4-email
            $table->string('resident');
            $table->string('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('language');
            $table->dropColumn('notes');
            $table->dropColumn('preferred');
            $table->dropColumn('resident');
            $table->dropColumn('email');
        });
    }
}
