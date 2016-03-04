<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrllistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urllist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parent');
            $table->string('url');
            $table->unique('url');
            $table->string('urltext');
            $table->boolean('processed');
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
        Schema::drop('urllist');
    }
}
