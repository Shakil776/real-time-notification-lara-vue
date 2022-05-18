<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\ShiftTimetable;

class DashboardController extends Controller
{
    public function index() {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $totalEmployees = Employee::where('status', '1')->count();
        $totalUsers = User::where('status', '1')->count();
        $totalDepartments = Department::where('status', '1')->count();
        $totalShifts = ShiftTimetable::where('status', '1')->count();
        return view('admin.dashboard.index', compact('totalEmployees', 'totalUsers', 'totalDepartments', 'totalShifts'));
    }
}
