<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cachetable', function (Blueprint $table) {
            $table->engine = 'MEMORY';
            $table->increments('id');
            $table->string('search_query');
            $table->string('doc_title');
            $table->string('doc_url');
            $table->string('doc_keywords');
            $table->integer('occurrence');
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
        Schema::drop('cachetable');
    }
}
