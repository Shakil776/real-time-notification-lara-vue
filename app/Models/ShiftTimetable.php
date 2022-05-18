<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftTimetable extends Model
{
    use HasFactory;

    protected $table = 'shift_timetables';

    protected $fillable = ["shift_name", "timetable_id", "created_by", "status", "remarks"];

    public function timetable() {
        return $this->belongsTo(Timetable::class);
    }
}
