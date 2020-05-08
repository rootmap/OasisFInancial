<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteSettingsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settingses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_name');
            $table->string('site_logo');
            $table->string('site_footer_logo');
            $table->string('toll_free_call_text');
            $table->string('toll_free_call_number');
            $table->string('contact_us_email_send');
            $table->string('application_notification_admin_email');
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
        Schema::dropIfExists('site_settingses');
    }
}
