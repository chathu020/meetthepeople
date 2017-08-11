<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->nullable()->unsigned();
            $table->string('clientCaseRefHead')->nullable();
            $table->string('clientCaseRefTail')->nullable();
            $table->integer('caseRef_id')->nullable()->unsigned();//description 
            $table->integer('approvedBy_id')->nullable()->unsigned();
            $table->string('refNo')->nullable();    
            $table->integer('recipient_id')->nullable()->unsigned();
            $table->string('recipient_Address')->nullable();
            $table->string('recipient_Salutation')->nullable();           
            $table->string('attention')->nullable();
            $table->string('subject')->nullable();    
            $table->string('content')->nullable();    
            $table->string('enclosed')->nullable();    
            $table->string('cc')->nullable();    
            $table->string('footer')->nullable();//Faithfully =0, sincere
            $table->integer('writer_id')->nullable()->unsigned();
            $table->string('comment')->nullable();    
            $table->timestamps();           
        });
        Schema::table('cases', function($table) {
           $table->foreign('client_id')->references('id')->on('clients');
           $table->foreign('writer_id')->references('id')->on('users');
           $table->foreign('approvedBy_id')->references('id')->on('approvalparties');
           $table->foreign('caseRef_id')->references('id')->on('caseReferences');
           $table->foreign('recipient_id')->references('id')->on('recipients');
        });
    }

 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cases');      
    }
}
