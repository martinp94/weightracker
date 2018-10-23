<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingDay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_day', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('tracking_period_id');
            $table->double('weight');
            $table->dateTime('measure_datetime');
            

            $table->foreign('tracking_period_id')->references('id')->on('tracking_period')->onDelete('cascade');;
            $table->unique('measure_datetime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracking_day');
    }
}
