<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->string('timetable_name');
            $table->time('start_work_time')->nullable();
            $table->time('valid_check_in_time')->nullable();
            $table->time('valid_check_in_time_to')->nullable();
            $table->time('end_work_time')->nullable();
            $table->time('valid_check_out_time')->nullable();
            $table->time('valid_check_out_time_to')->nullable();
            $table->time('overtime_start')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('timetables');
    }
}
