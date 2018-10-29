<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMeasureDatetimeToTypeDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracking_day', function (Blueprint $table) {
            $table->dropColumn('measure_datetime');

            $table->date('measure_date')->default(\Carbon\Carbon::today());

            $table->unique('measure_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
