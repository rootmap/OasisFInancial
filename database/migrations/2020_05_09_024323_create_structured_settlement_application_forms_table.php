<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStructuredSettlementApplicationFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structured_settlement_application_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('are_you_over_the_age_of_18');
            $table->string('address');
            $table->string('city');
            $table->integer('state');
            $table->string('state_Inactive');
            $table->string('zip_code');
            $table->string('when_did_your_case_settle');
            $table->string('email');
            $table->string('phone');
            $table->string('how_often_do_you_receive_payments');
            $table->string('name_of_the_company_sending_your_payments');
            $table->string('what_was_the_total_amount_of_the_award');
            $table->string('how_much_do_you_receive_in_each_payment');
            $table->string('how_much_do_you_need_now');
            $table->string('refer');
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
        Schema::dropIfExists('structured_settlement_application_forms');
    }
}
