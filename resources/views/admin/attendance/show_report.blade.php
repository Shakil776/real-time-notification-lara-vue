@extends('admin.master')

@section('title', 'Report')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/multiselect/css/bootstrap-multiselect.css') }}">
<style>
    div.dt-buttons {
        float: right;
        padding: 7px;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Attendances</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.view')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Report
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Advanced Search -->
        <section id="advanced-search-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Generate Report</h4>
                        </div>
                        <!--Search Form -->
                        <div class="card-body mt-2">
                            <form class="dt_adv_search" id="attendance_report_search">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-row">
                                            <div class="col-md-5">
                                                <label for="emp_id">Select Employee</label> <br>
                                                <select id="emp_id" name="emp_id[]" multiple="multiple">
                                                    @foreach($departmentWithEmployees as $data)
                                                    <optgroup label="{{ $data->department_name }}">
                                                        @if(!empty($data->employees))
                                                            @foreach($data->employees as $employee)
                                                            <option value="{{ $employee->device_emp_id }}">{{ $employee->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="start_time">Start Time</label>
                                                <input type="text" name="start_time" id="start_time" class="form-control flatpickr-basic" placeholder="DD-MM-YYYY" />
                                            </div>

                                            <div class="col-md-2">
                                                <label for="end_time">End Time</label>
                                                <input type="text" name="end_time" id="end_time" class="form-control flatpickr-basic2" placeholder="DD-MM-YYYY" />
                                            </div>

                                            <div class="col-md-2">
                                                <label></label>
                                                <button type="submit" class="btn btn-success form-control" id="showReport">Report</button>
                                            </div>
                                            <div class="col-md-1">
                                                <label></label>
                                                <button type="button" class="btn btn-danger form-control" onclick="form_reset()">Clear</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>

                        <hr class="my-0" />

                        <div class="card-datatable">
                            <table class="attendance-report-table table">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Emp. ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Date</th>
                                        <th>Check IN</th>
                                        <th>Check OUT</th>
                                        <th>Work Time(Min)</th>
                                        <th>OT(Min)</th>
                                        <th>Attend(Min)</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Advanced Search -->
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('admin/assets/multiselect/js/bootstrap-multiselect.min.js') }}"></script>
<script>
    // multiselect checkbox
    $('#emp_id').multiselect({
        enableClickableOptGroups: true
    });
    // validate search
    // user create form validation
    // var attSearch = $('#attendance_report_search');
    // if (attSearch.length) {
    //     attSearch.validate({
    //         rules: {
    //             'emp_id[]':{
    //                 required: true
    //             },
    //             'start_time': {
    //                 required: true
    //             },
    //             'end_time': {
    //                 required: true
    //             }
    //         },
    //         messages: {
    //             'emp_id[]': {
    //                 required: "Select Employee"
    //             },
    //             'start_time': {
    //                 required: "Select Start Date"
    //             },
    //             'end_time': {
    //                 required: "Select End Date"
    //             }
    //         },
    //     });
    // }
</script>
@include('admin.attendance.attendance_js')
@endpush