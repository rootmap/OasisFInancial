<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePre-settlementFundingContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre-settlement_funding_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('section_title');
            $table->string('section_detail');
            $table->string('icon_one');
            $table->string('icon_one_detail');
            $table->string('icon_two');
            $table->string('icon_two_detail');
            $table->string('icon_three');
            $table->string('icon_three_detail');
            $table->string('button_text');
            $table->string('button_link_url');
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
        Schema::dropIfExists('pre-settlement_funding_contents');
    }
}
