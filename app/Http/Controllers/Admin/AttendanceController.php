<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{

    // report
    public function report(Request $request)
    {   
        if ($request->ajax()) {

            $query  = DB::table('employees as emp')
                ->leftjoin('attendance_log as al', 'al.emp_id', 'emp.device_emp_id')
                ->join('departments as dep', 'dep.id', 'emp.department_id')
                ->join('shift_timetables as st', 'st.id', 'emp.shift_timetable_id')
                ->join('timetables as tt', 'tt.id', 'st.timetable_id')
                ->select('emp.id', 'emp.department_id', 'emp.shift_timetable_id', 'emp.device_emp_id', 'emp.name', 'emp.email', 'emp.mobile', 'emp.position', 'dep.department_name', 'st.shift_name', 'st.timetable_id', 'tt.timetable_name', 'tt.start_work_time', 'tt.valid_check_in_time', 'tt.valid_check_in_time_to', 'tt.end_work_time', 'tt.valid_check_out_time', 'tt.valid_check_out_time_to', 'tt.overtime_start', 'al.auth_time', 'al.auth_date', 'al.emp_id', 'al.auth_date_time', DB::raw("MIN(al.auth_time) AS check_in, MAX(al.auth_time) AS check_out"))
                ->groupBy('emp.device_emp_id', DB::raw('DATE(al.auth_date_time)'));

                if ($request->emp_id !== null) {
                    $query->whereIn('al.emp_id', $request->emp_id);
                }

                if ($request->start_time !== null && $request->end_time !== null) {
                    $query = $query->whereBetween('al.auth_date', [$request->start_time, $request->end_time]);
                }

            $data = $query->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('check_in', function ($data) {
                    $check_in = !empty($data->check_in) ? $data->check_in : "-";
                    return $check_in; 
                })
                ->addColumn('check_out', function ($data) {
                    $check_out = !empty($data->check_in) && !empty($data->check_out) && $data->check_in == $data->check_out ? "-" : $data->check_out;
                    return $check_out; 
                })
                ->addColumn('work', function ($data) {
                    if(!empty($data->start_work_time) && !empty($data->end_work_time)){
                        $to = strtotime($data->end_work_time);
                        $from = strtotime($data->start_work_time);
                        $diff_in_minutes = round(($to - $from) / 60);
                        
                        if($diff_in_minutes < 0){
                            $work = 0;
                        }else{
                            $work = $diff_in_minutes;
                        }
                    }else{
                        $work = 0;
                    }
                    return $work;
                })
                ->addColumn('ot', function ($data) {
                    if(!empty($data->check_out) && !empty($data->overtime_start)){
                        $to = strtotime($data->check_out);
                        $from = strtotime($data->overtime_start);
                        $diff_in_minutes = round(($to - $from) / 60);
                        if($diff_in_minutes < 0){
                            $overtime = 0;
                        }else{
                            $overtime = $diff_in_minutes;
                        }
                    }else{
                        $overtime = 0;
                    }
                    return $overtime;
                })
                ->addColumn('attend', function ($data) {
                    if(!empty($data->check_in) && !empty($data->check_out)){

                        $to = strtotime($data->check_out);
                        $from = strtotime($data->check_in);
                        $diff_in_minutes = round(($to - $from) / 60);
                        
                        if($diff_in_minutes < 0){
                            $attend = 0;
                        }else{
                            $attend = $diff_in_minutes;
                        }
                    }else{
                        $attend = 0;
                    }
                    return $attend;
                })
                ->addColumn('status', function ($data) {
                    if(!empty($data->check_in) || !empty($data->check_out)){
                        if($data->valid_check_in_time_to > $data->check_in
                        && $data->valid_check_out_time <= $data->check_out){
                            $status = "P";
                        } else{
                            $status = "A";
                        }
                    }else{
                        $status = "A";
                    }
                    return $status;
                })
                ->make(true);
        }

        $departmentWithEmployees = Department::with('employees')->where('status', 1)->get();
        return view('admin.attendance.show_report', compact('departmentWithEmployees'));
    }
}
