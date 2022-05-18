<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimetableController extends Controller
{
    public $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('TimeTable.View')) {
            return view('errors.403');
        }

        $timetables = Timetable::where('status', 1)->orderBy('id','DESC')->get();
        return view('admin.attendance.timetable', compact('timetables'));
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('TimeTable.Create')) {
            return view('errors.403');
        }

        if ($request->isMethod('POST')) {
            $data = Validator::make($request->all(), [
                'timetable_name' => ['required', 'unique:timetables'],
                'start_work_time' => ['required'],
                'valid_check_in_time' => ['required'],
                'valid_check_in_time_to' => ['required'],
                'end_work_time' => ['required'],
                'valid_check_out_time' => ['required'],
                'valid_check_out_time_to' => ['required'],
                'overtime_start' => ['required'],
            ]);

            if ($data->fails()) {
                return redirect()->back()->withErrors($data)->withInput();
            } 

            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $timetable = Timetable::create($input);
            toastr()->success('Timetable created successfully.', 'Success!');
            return redirect()->route('timetables.index');
        }
    }

    public function destroy($id) {
        if (is_null($this->user) || !$this->user->can('TimeTable.Delete')) {
            return view('errors.403');
        }
        
        $timetable = Timetable::find($id);
        if (!is_null($timetable)) {
            $timetable->delete();
        }

        toastr()->success('Timetable deleted successfully.', 'Success!');
        return redirect()->route('timetables.index');
    }


    public function editTimetable(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('TimeTable.Edit')) {
            return view('errors.403');
        }

        if ($request->ajax()) {
            $data = $request->all();

            $timetable = Timetable::find($data['id']);

            if (!is_null($timetable)) {
                return response()->json([
                    'data' => $timetable,
                    'success' => true
                ]);
            }  
        }
    }

    public function updateTimetable(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('TimeTable.Edit')) {
            return view('errors.403');
        }

        if ($request->ajax()) {
            $data = $request->all();

            Timetable::where('id', $data['timetable_id'])->update(['timetable_name' => $data['timetable_name'], 'start_work_time' => $data['start_work_time'], 'valid_check_in_time' => $data['valid_check_in_time'], 'valid_check_in_time_to' => $data['valid_check_in_time_to'], 'end_work_time' => $data['end_work_time'], 'valid_check_out_time' => $data['valid_check_out_time'], 'valid_check_out_time_to' => $data['valid_check_out_time_to'], 'overtime_start' => $data['overtime_start'], 'remarks' => $data['remarks']]);
            toastr()->success('Timetable updated successfully.', 'Success!');
            return response()->json([
                'success' => true
            ]);
        }
    }

     // change timetable status
     public function changeTimetableStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            Timetable::where('id', $data['timetable_id'])->update(['status'=>$status]);

            return response()->json([
                'status' => $status,
                'timetable_id' => $data['timetable_id']
            ]);
        }
    }
}
