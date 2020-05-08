<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYouAreNotAloneVideosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('you_are_not_alone_videoses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('feedback_user_name');
            $table->string('from_location');
            $table->string('section_detail');
            $table->string('play_video_text');
            $table->string('video_background_image');
            $table->string('youtube_video_link');
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
        Schema::dropIfExists('you_are_not_alone_videoses');
    }
}
