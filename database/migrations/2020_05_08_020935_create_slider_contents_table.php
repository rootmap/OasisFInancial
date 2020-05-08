<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slider_header_with_animation');
            $table->string('slider_sub_title_with_animation');
            $table->string('slider_button_top_text');
            $table->string('button_text');
            $table->string('rating_image');
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
        Schema::dropIfExists('slider_contents');
    }
}
