<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_timetables', function (Blueprint $table) {
            $table->id();
            $table->string('shift_name');
            $table->integer('timetable_id')->nullable();
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
        Schema::dropIfExists('shift_timetables');
    }
}
