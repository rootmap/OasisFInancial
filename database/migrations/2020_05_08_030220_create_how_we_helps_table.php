<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHowWeHelpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('how_we_helps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('block_heading');
            $table->string('block_detail');
            $table->string('item_one_icon');
            $table->string('item_one_detail');
            $table->string('item_two_icon');
            $table->string('item_two_detail');
            $table->string('item_three_icon');
            $table->string('item_three_detail');
            $table->string('item_four_icon');
            $table->string('item_four_detail');
            $table->string('module_status');
            $table->integer('store_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            
            $table->softDeletes();
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
        Schema::dropIfExists('how_we_helps');
    }
}
