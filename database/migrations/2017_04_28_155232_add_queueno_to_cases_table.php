<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQueuenoToCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
           $table->integer('queueno')->nullable()->unsigned();//queue_id 
            
        });

        Schema::table('cases', function($table) {
                $table->foreign('queueno')->references('id')->on('queue');          
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign('cases_queueno_foreign');
           $table->dropColumn('queueno');
        });
    }
}
