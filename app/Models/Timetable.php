<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $table = 'timetables';

    protected $fillable = ["timetable_name", "start_work_time", "valid_check_in_time", "valid_check_in_time_to", "end_work_time", "valid_check_out_time", "valid_check_out_time_to", "overtime_start", "created_by", "status", "remarks"];
}
