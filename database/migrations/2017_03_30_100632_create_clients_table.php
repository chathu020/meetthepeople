<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nric')->unique();
            $table->string('name');
            $table->integer('color'); // pink-0, blue-1
            $table->string('blkNo');
            $table->string('unitNo');
            $table->string('address');
            $table->string('postalCode');
            $table->boolean('sex');//male -0, female-1
            $table->integer('race');//C-0, M-1, I-2, Other-3
            $table->integer('homeTel');         
            $table->integer('pagerNo');
            $table->integer('officeTel');
            $table->integer('handphone');
            $table->integer('accomodationType');//hdb-0, private -1
            $table->integer('roomType')->nullable()->unsigned();
            $table->integer('status');//own-0, rented-1
            $table->date('dateOfBirth');
            $table->boolean('noContact');
            $table->timestamps();
        });
         Schema::table('clients', function($table) {
           $table->foreign('roomType')->references('id')->on('accomodations');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
