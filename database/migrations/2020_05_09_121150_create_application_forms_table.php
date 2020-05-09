<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('how_much_money_you_need');
            $table->string('date_of_accident');
            $table->integer('what_state_case');
            $table->string('what_state_case_name');
            $table->integer('case_type_id');
            $table->string('case_type_id_name');
            $table->integer('hear_about_us_id');
            $table->string('hear_about_us_id_name');
            $table->string('email');
            $table->string('phone');
            $table->string('how_should_we_contact');
            $table->string('address');
            $table->string('city');
            $table->integer('state');
            $table->string('state_name');
            $table->string('zip_code');
            $table->string('attorney_first_name');
            $table->string('attorney_last_name');
            $table->string('law_firm_name');
            $table->string('law_firm_phone');
            $table->string('application_status');
            $table->string('applicant_verification_status');
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
        Schema::dropIfExists('application_forms');
    }
}
