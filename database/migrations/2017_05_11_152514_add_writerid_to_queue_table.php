<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWriteridToQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('queue', function (Blueprint $table) {
           $table->integer('writer_id')->nullable()->unsigned();
            
        });

        Schema::table('queue', function($table) {
                $table->foreign('writer_id')->references('id')->on('users');          
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('queue', function (Blueprint $table) {
            $table->dropForeign('queue_writer_id_foreign');
            $table->dropColumn('writer_id');
        });
    }
}
