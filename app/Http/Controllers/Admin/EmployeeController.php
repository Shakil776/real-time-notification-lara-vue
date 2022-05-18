<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\ShiftTimetable;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
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
        if (is_null($this->user) || !$this->user->can('Employee.View')) {
            return view('errors.403');
        }

        $employees = Employee::with('department', 'shift')->orderBy('id','DESC')->get();
        return view('admin.employee.index', compact('employees'));
    }

    public function create()
    {
        if (is_null($this->user) || !$this->user->can('Employee.Create')) {
            return view('errors.403');
        }

        $departments = Department::where('status', 1)->get();
        $shifts = ShiftTimetable::where('status', 1)->get();
        return view('admin.employee.create', compact('departments', 'shifts'));
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('Employee.Create')) {
            return view('errors.403');
        }

        // Validation Data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|max:100|email|unique:employees',
            'mobile' => 'required',
            'department_id' => 'required',
            'shift_timetable_id' => 'required',
            'dob' => 'required',
            'position' => 'required',
            'hire_date' => 'required',
            'salary' => 'required',
            'device_emp_id' => 'required',
            'gender' => 'required',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // upload employee image
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            if($image_tmp->isValid()){
                $file_name = $image_tmp->getClientOriginalName();
                $image_name = pathinfo($file_name, PATHINFO_FILENAME);
                $extension = $image_tmp->getClientOriginalExtension();
                $imageName =  rand(111, 99999).time().'.'.$extension;
                $imagePath = 'uploads/employeeImage/'.$imageName;
                Image::make($image_tmp)->resize(300, 300)->save($imagePath);
            }
        }

        // Create New Employee
        $input = $request->all();
        $input['created_by'] = Auth::user()->id;
        if(!empty($imageName)){
            $input['image'] = $imageName;
        }
        $employee = Employee::create($input);
        toastr()->success('Employee created Successfully.', 'Success!');
        return redirect()->route('employees.index');
    }

    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('Employee.Edit')) {
            return view('errors.403');
        }

        $employee = Employee::find($id);
        $departments = Department::where('status', 1)->get();
        $shifts = ShiftTimetable::where('status', 1)->get();
        return view('admin.employee.edit', compact('employee', 'departments', 'shifts'));
    }

    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('Employee.Edit')) {
            return view('errors.403');
        }

        // Validation Data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|max:100|email|unique:employees,email,'.$id,
            'mobile' => 'required',
            'department_id' => 'required',
            'shift_timetable_id' => 'required',
            'dob' => 'required',
            'position' => 'required',
            'hire_date' => 'required',
            'salary' => 'required',
            'device_emp_id' => 'required',
            'gender' => 'required',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // upload employee image
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            if($image_tmp->isValid()){
                $file_name = $image_tmp->getClientOriginalName();
                $image_name = pathinfo($file_name, PATHINFO_FILENAME);
                $extension = $image_tmp->getClientOriginalExtension();
                $imageName =  rand(111, 99999).time().'.'.$extension;
                $imagePath = 'uploads/employeeImage/'.$imageName;
                Image::make($image_tmp)->resize(300, 300)->save($imagePath);
            }
        }

        // update Employee
        $employee = Employee::find($id);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->mobile = $request->mobile;
        $employee->dob = $request->dob;
        $employee->gender = $request->gender;
        $employee->position = $request->position;
        $employee->hire_date = $request->hire_date;
        $employee->address = !empty($request->address) ? $request->address : null;
        $employee->salary = $request->salary;
        $employee->remarks = !empty($request->remarks) ? $request->remarks : null;
        $employee->image = $imageName ?? $employee->image;
        $employee->department_id = $request->department_id;
        $employee->shift_timetable_id = $request->shift_timetable_id;
        $employee->device_emp_id = $request->device_emp_id;
        $employee->update();

        toastr()->success('Employee Updated Successfully.', 'Success!');
        return redirect()->route('employees.index');
        
    }

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('Employee.Delete')) {
            return view('errors.403');
        }
        
        $employee = Employee::find($id);
        if (!is_null($employee)) {
            $employee->delete();
        }

        toastr()->success('Employee deleted successfully.', 'Success!');
        return back();
    }

    // change employee status
    public function changeEmployeeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            Employee::where('id', $data['employee_id'])->update(['status'=>$status]);

            return response()->json([
                'status' => $status,
                'employee_id' => $data['employee_id']
            ]);
        }
    }
}
