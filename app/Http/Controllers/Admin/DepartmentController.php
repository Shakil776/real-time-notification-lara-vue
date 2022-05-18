<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\DepartmentCreatedEvent;

class DepartmentController extends Controller
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
        if (is_null($this->user) || !$this->user->can('Department.View')) {
            return view('errors.403');
        }

        $departments = Department::orderBy('id','DESC')->get();
        return view('admin.attendance.department', compact('departments'));
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('Department.Create')) {
            return view('errors.403');
        }
        
        if ($request->isMethod('POST')) {
            $data = Validator::make($request->all(), [
                'department_name' => ['required', 'unique:departments'],
            ]);

            if ($data->fails()) {
                return redirect()->back()->withErrors($data)->withInput();
            } 

            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $department = Department::create($input);
            toastr()->success('Department created successfully.', 'Success!');
            // dispatch event
            DepartmentCreatedEvent::dispatch($department);
            return redirect()->route('departments.index');
        }
    }

    public function destroy($id) {
        if (is_null($this->user) || !$this->user->can('Department.Delete')) {
            return view('errors.403');
        }

        $department = Department::find($id);
        if (!is_null($department)) {
            $department->delete();
        }

        toastr()->success('Department deleted successfully.', 'Success!');
        return redirect()->route('departments.index');
    }

    public function editDepartment(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('Department.Edit')) {
            return view('errors.403');
        }

        if ($request->ajax()) {
            $data = $request->all();

            $department = Department::find($data['id']);

            if (!is_null($department)) {
                return response()->json([
                    'department' => $department,
                    'success' => true
                ]);
            }  
        }
    }

    public function updateDepartment(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('Department.Edit')) {
            return view('errors.403');
        }

        if ($request->ajax()) {
            $data = $request->all();

            Department::where('id', $data['id'])->update(['department_name' => $data['name'], 'remarks' => $data['remarks']]);
            toastr()->success('Department updated successfully.', 'Success!');
            return response()->json([
                'success' => true
            ]);
        }
    }

    // change department status
    public function changeDepartmentStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            Department::where('id', $data['department_id'])->update(['status'=>$status]);

            return response()->json([
                'status' => $status,
                'department_id' => $data['department_id']
            ]);
        }
    }
}
