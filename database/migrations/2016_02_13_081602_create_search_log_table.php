<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searchlogtable', function (Blueprint $table) {
            $table->string('ip');
            $table->string('keyword');
            $table->bigInteger('result_count')->default(0);
            $table->bigInteger('correct_count')->default(0);
            $table->bigInteger('incorrect_count')->default(0);
            $table->string('textual_search_indexing_technique')->default('none');
            $table->double('textual_search_space_kb', 15, 5)->default(0.0);
            $table->double('textual_search_time', 15, 10)->default(0.0);
            $table->string('location_search_indexing_technique')->default('none');
            $table->double('location_search_space_kb', 15, 5)->default(0.0);
            $table->double('location_search_time', 15, 10)->default(0.0);
            $table->primary('ip');
            $table->timestamps();
        });

        //Laravel bug : Composite key definition alternative
        DB::statement('ALTER TABLE  `searchlogtable` DROP PRIMARY KEY , ADD PRIMARY KEY (  `ip` ,  `keyword` , `textual_search_indexing_technique` , `location_search_indexing_technique`) ;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('searchlogtable');
    }
}
