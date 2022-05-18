@extends('admin.master')

@section('title', 'Departments')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-8">
                    <h2 class="content-header-title float-left">Departments</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.view')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">All Departments
                            </li>
                        </ol>
                    </div>
                </div>
                @can('Department.Create')
                    <div class="col-4">
                        <button class="btn btn-primary text-white float-right" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-toggle="modal" data-target="#addNewDepartment" data-backdrop="static" data-keyboard="false">
                            <span>
                                <i class="fas fa-plus-square"></i>
                                Add New
                            </span>
                        </button>
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
                        <table class="datatables-basic table text-center" id="departmentTable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($departments as $department)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $department->department_name }}</td>
                                    <td>{{ $department->remarks }}</td>
                                    <td>
                                        @if($department->status == 1) 
                                            <a class="changeDepartmentStatus" id="department-{{ $department->id }}" department_id="{{ $department->id }}" href="javascript:void(0)" title="Inactive"><i class="fas fa-toggle-on" status="Active"></i></a>  
                                        @else 
                                            <a class="changeDepartmentStatus" id="department-{{ $department->id }}" department_id="{{ $department->id }}" href="javascript:void(0)" title="Active"><i class="fas fa-toggle-off" status="Inactive"></i></a> 
                                        @endif
                                    </td>
                                    <td>
                                        @can('Department.Edit')
                                            <a title="Edit" class="btn btn-success text-white" href="javascript:" data-toggle="modal" data-target="#editDepartment" data-backdrop="static" data-keyboard="false" id="editDep" data-id="{{ $department->id }}"><i data-feather='edit'></i></a>
                                        @endcan
                                        
                                        @can('Department.Delete')
                                            <a title="Delete" class="btn btn-danger text-white deleteDepartment" href="javascript:"><i data-feather='trash-2'></i></a>

                                            <form id="departmentDeleteForm" action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: none;">
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

<!-- Add New department modal -->
<div class="modal fade text-left" id="addNewDepartment" tabindex="-1" role="dialog" aria-labelledby="department" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="department">Add New Department</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('departments.store') }}" method="POST" id="jquery-val-form">
                @csrf
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="department_name">Department Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('department_name') is-invalid @enderror" id="department_name" name="department_name" placeholder="Department Name" value="{{ old('department_name') }}" />
                        @error('department_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Remarks"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Edit department modal -->
<div class="modal fade text-left" id="editDepartment" tabindex="-1" role="dialog" aria-labelledby="departmentEdit" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="departmentEdit">Edit Department</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" id="departmentUpdateForm">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="name">Department Name<span class="text-danger">*</span></label>
                        <input type="hidden" id="department_id" name="department_id" value="">
                        <input type="text" class="form-control department_name @error('department_name') is-invalid @enderror" id="department_name_edit" name="department_name" placeholder="Department Name" value="" />
                        @error('department_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="remarks">Remarks</label>
                        <textarea class="form-control remarks" id="remarks_edit" name="remarks" rows="3" placeholder="Remarks"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="submit" value="Submit" id="updateDepartment">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        // datatable init
        if ($('#departmentTable').length) {
            $('#departmentTable').DataTable({
                responsive: true,
                processing: true,
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            });
        }

        // add department validation
        var jqForm = $('#aaddNewDepartment');
        if (jqForm.length) {
            jqForm.validate({
                rules: {
                    'department_name': {
                        required: true
                    }
                }
            });
        }

        // edit department
        $(document).on('click', '#editDep', function (event) {
            event.preventDefault();
            $('#editDepartment').modal('show');
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url: "/edit-department",
                data: {
                    id: id
                },
                success: function(resp) {
                    if (resp.success === true) {
                        $("#department_id").val(resp.department.id);
                        $("#department_name_edit").val(resp.department.department_name);
                        $("#remarks_edit").val(resp.department.remarks);
                    } else {
                        console.log("Error");
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        });

        // update department
        $(document).on('click', '#updateDepartment', function (event) {
            event.preventDefault()
            var id = $("#department_id").val();
            var name = $("#department_name_edit").val();
            var remarks = $("#remarks_edit").val();
           
            $.ajax({
              url: '/update-department',
              type: "POST",
              data: {
                id: id,
                name: name,
                remarks: remarks,
              },
              success: function (resp) {
                if (resp.success === true) {
                    $('#departmentUpdateForm').trigger("reset");
                    $('#editDepartment').modal('hide');
                    window.location.reload(true);
                } else {
                    console.log("Error");
                }  
              },
              error: function() {
                    console.log("Error");
                }
          });
        });
 
        // delete department
        $(document).on("click", ".deleteDepartment", function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.isConfirmed) {
                    $("#departmentDeleteForm").submit();
                }
            });
        });

        // change department status
        $(document).on("click", ".changeDepartmentStatus", function(){
            var status = $(this).children("i").attr("status");
            var department_id = $(this).attr("department_id");
            
            $.ajax({
                type: 'POST',
                url: '/department-status',
                data: {status:status, department_id:department_id},
                success: function(resp){
                    if(resp['status'] == 0){
                        $("#department-"+department_id).html("<i class='fas fa-toggle-off' status='Inactive'></i>");
                    } else if(resp['status'] == 1){
                        $("#department-"+department_id).html("<i class='fas fa-toggle-on' status='Active'></i>");
                    }
                },
                error: function(){
                    console.log("Error");
                }
            });
        });
        
    </script>
@endpush