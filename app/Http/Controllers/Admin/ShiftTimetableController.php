<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShiftTimetable;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShiftTimetableController extends Controller
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
        if (is_null($this->user) || !$this->user->can('Shift.View')) {
            return view('errors.403');
        }

        $shifts = ShiftTimetable::with('timetable')->where('status', 1)->orderBy('id','DESC')->get();
        $timetables = Timetable::where('status', 1)->get();
        return view('admin.attendance.shift', compact('shifts', 'timetables'));
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('Shift.Create')) {
            return view('errors.403');
        }
        
        if ($request->isMethod('POST')) {
            $data = Validator::make($request->all(), [
                'shift_name' => ['required', 'unique:shift_timetables'],
                'timetable_id' => ['required']
            ]);

            if ($data->fails()) {
                return redirect()->back()->withErrors($data)->withInput();
            } 

            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $shiftTimetable = ShiftTimetable::create($input);
            toastr()->success('Shift created successfully.', 'Success!');
            return redirect()->route('shifts.index');
        }
    }

    public function destroy($id) {
        if (is_null($this->user) || !$this->user->can('Shift.Delete')) {
            return view('errors.403');
        }

        $shiftTimetable = ShiftTimetable::find($id);
        if (!is_null($shiftTimetable)) {
            $shiftTimetable->delete();
        }

        toastr()->success('Shift deleted successfully.', 'Success!');
        return redirect()->route('shifts.index');
    }

    public function editShift(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('Shift.Edit')) {
            return view('errors.403');
        }

        if ($request->ajax()) {
            $data = $request->all();

            $shift = ShiftTimetable::find($data['id']);

            $timetables = Timetable::where('status', 1)->orderBy('id','DESC')->get();

            if (!is_null($shift)) {
                return response()->json([
                    'data' => $shift,
                    'timetables' => $timetables,
                    'success' => true
                ]);
            }  
        }
    }

    public function updateShift(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('Shift.Edit')) {
            return view('errors.403');
        }

        if ($request->ajax()) {
            $data = $request->all();

            ShiftTimetable::where('id', $data['shift_id'])->update(['shift_name' => $data['shift_name'], 'timetable_id' => $data['timetable_id'], 'remarks' => $data['remarks']]);
            toastr()->success('Shift updated successfully.', 'Success!');
            return response()->json([
                'success' => true
            ]);
        }
    }

    // change shift status
    public function changeShiftStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            ShiftTimetable::where('id', $data['shift_id'])->update(['status'=>$status]);

            return response()->json([
                'status' => $status,
                'shift_id' => $data['shift_id']
            ]);
        }
    }
}
