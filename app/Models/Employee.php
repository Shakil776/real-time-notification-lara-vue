<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = ["department_id", "shift_timetable_id", "device_emp_id", "name", "email", "mobile", "dob", "gender", "position", "hire_date", "address", "salary", "remarks", "status", "created_by", "image"];

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function shift() {
        return $this->belongsTo(ShiftTimetable::class, 'shift_timetable_id');
    }

    public function attendances() {
        return $this->hasMany(Attendance::class, 'emp_id', 'device_emp_id');
    }

    
}
