<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasta', function (Blueprint $table) {
            $table->bigIncrements('id');
	    $table->integer('user_id')->nullable()->default(0);
	    $table->uuid('hash');
            $table->longText('body');
	    $table->foreign('user_id')->references('id')->on('users');
	    $table->boolean('is_listed')->default(1);
	    $table->boolean('is_private')->default(0);
	    $table->integer('lang_id')->nullable()->default(0);
	    $table->foreign('lang_id')->references('id')->on('linguist');
	    $table->timestampTz('up_to')->nullable()->default(NULL);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasta');
    }
}
