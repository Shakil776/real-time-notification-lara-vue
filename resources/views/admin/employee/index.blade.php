@extends('admin.master')

@section('title', 'Employees')

@push('css')
<style>
    .left-col {
        float: left;
        width: 25%;
    }
 
    .center-col {
        float: left;
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: end;
        margin-top: 20px;
    }
 
    .right-col {
        float: left;
        width: 25%;
    }

</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-8">
                    <h2 class="content-header-title float-left">Employees</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.view')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">All Employees
                            </li>
                        </ol>
                    </div>
                </div>
                @can('Employee.Create')
                    <div class="col-4">
                        <a class="btn btn-primary text-white float-right" href="{{ route('employees.create') }}">Create New Employee</a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
    
    <div class="content-body">
        <!-- Basic table -->
        <section id="basic-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <table class="datatables-basic table text-center" id="employeeTable">
                            <thead>
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Shift</th>
                                    <th>Salary</th>
                                    <th>Hire Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($employees as $employee)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>
                                        @if(!empty($employee->image))
                                            <img src="{{ asset('uploads/employeeImage/'.$employee->image) }}" alt="Employee Image" width="80">
                                        @else
                                            <img src="{{ asset('admin/assets/img/default.png') }}" alt="Employee Image" width="80">
                                        @endif
                                    </td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->mobile }}</td>
                                    <td>{{ $employee->position }}</td>
                                    <td>{{ $employee->department->department_name }}</td>
                                    <td>{{ $employee->shift->shift_name }}</td>
                                    <td>TK. {{ $employee->salary }}</td>
                                    <td>{{ $employee->hire_date }}</td>
                                    <td>
                                        @if($employee->status == 1) 
                                            <a class="changeEmployeeStatus" id="employee-{{ $employee->id }}" employee_id="{{ $employee->id }}" href="javascript:void(0)" title="Inactive"><i class="fas fa-toggle-on" status="Active"></i></a>  
                                        @else 
                                            <a class="changeEmployeeStatus" id="employee-{{ $employee->id }}" employee_id="{{ $employee->id }}" href="javascript:void(0)" title="Active"><i class="fas fa-toggle-off" status="Inactive"></i></a> 
                                        @endif
                                    </td>
                                    <td>
                                        @can('Employee.Edit')
                                            <a title="Edit" class="btn btn-success text-white" href="{{ route('employees.edit', $employee->id) }}"><i data-feather='edit'></i></a>
                                        @endcan
                                        
                                        @can('Employee.Delete')
                                            <a title="Delete" class="btn btn-danger text-white deleteEmployee" href="javascript:"><i data-feather='trash-2'></i></a>

                                            <form id="employeeDeleteForm" action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Basic table -->
    </div>
</div>
@endsection

@push('js')
    @include('admin.employee.employees_js')
@endpush