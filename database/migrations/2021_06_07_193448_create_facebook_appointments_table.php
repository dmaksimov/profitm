<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacebookAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('facebook_campaign_id');
            $table->integer('customer_id');
            $table->dateTime('date');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('status')->default(0);
        });
    }

    /**~
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facebook_appointments');
    }
}
