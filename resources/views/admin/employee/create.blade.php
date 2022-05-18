@extends('admin.master')

@section('title', 'Create Employee')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Employees</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.view')}}">Home</a>
                            </li>
                            {{-- @can('User.View') --}}
                            <li class="breadcrumb-item"><a href="{{route('employees.index')}}">All Employees</a>
                            </li>
                            {{-- @endcan --}}
                            <li class="breadcrumb-item active">Employee Create
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Create New Employee</h4>
                        
                        <form id="employee-create-form" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label class="form-label" for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="mobile">Mobile<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" placeholder="Enter Mobile">
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="dob">Date of Birth<span class="text-danger">*</span></label>
                                    <input type="text" name="dob" id="dob" class="form-control flatpickr-basic @error('dob') is-invalid @enderror" placeholder="YYYY-MM-DD" />
                                    @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="position">Position<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" placeholder="Enter Position">
                                    @error('position')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="hire_date">Hire Date<span class="text-danger">*</span></label>
                                    <input type="text" name="hire_date" id="hire_date" class="form-control flatpickr-basic @error('hire_date') is-invalid @enderror" placeholder="YYYY-MM-DD" />
                                    @error('hire_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="department">Department<span class="text-danger">*</span></label>
                                    <select name="department_id" id="department" class="form-control select2 @error('department_id') is-invalid @enderror">
                                        <option value="">Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="shift">Shift<span class="text-danger">*</span></label>
                                    <select name="shift_timetable_id" id="shift" class="form-control select2 @error('shift_timetable_id') is-invalid @enderror">
                                        <option value="">Select Shift</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->shift_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('shift_timetable_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="salary">Salary<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" placeholder="Enter Salary">
                                    @error('salary')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="profileImage">Profile Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('salary') is-invalid @enderror" name="image" id="profileImage" />
                                        <label class="custom-file-label" for="profileImage">Choose profile Image</label>
                                    </div>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="device_emp_id">Device Employee ID<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('device_emp_id') is-invalid @enderror" id="device_emp_id" name="device_emp_id" placeholder="Device Employee ID">
                                    @error('device_emp_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="profileImage">Gender<span class="text-danger">*</span></label>
                                    <div class="demo-inline-spacing">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="Male" checked />
                                            <label class="form-check-label" for="gender">Male</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="Female" />
                                            <label class="form-check-label" for="gender">Female</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="Others" />
                                            <label class="form-check-label" for="gender">Others</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Address"></textarea>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Remarks"></textarea>
                                </div>
                            </div>
                           
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Employee</button>
                        </form>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>
@endsection

@push('js')
   @include('admin.employee.employees_js')
@endpush
