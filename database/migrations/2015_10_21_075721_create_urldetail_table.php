<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrldetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urldetail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('urllistid');
            $table->string('url');
            $table->string('title');
            $table->string('h1');
            $table->string('metadesc');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('location')->nullable();
            $table->string('keywords');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('urldetail');
    }
}
