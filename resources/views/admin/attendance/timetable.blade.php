@extends('admin.master')

@section('title', 'Timetable')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-8">
                    <h2 class="content-header-title float-left">Timetables</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.view')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">All Timetables
                            </li>
                        </ol>
                    </div>
                </div>
                @can('TimeTable.Create')
                    <div class="col-4">
                        <button class="btn btn-primary text-white float-right" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-toggle="modal" data-target="#addNewTimetable">
                            <span>
                                <i class="far fa-plus-square"></i>
                                Add New Timetable
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
                        <table class="datatables-basic table text-center" id="timeTablesTable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Start Work Time</th>
                                    <th>Valid Checkin Time</th>
                                    <th>End Work Time</th>
                                    <th>Overtime Start</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($timetables as $timetable)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $timetable->timetable_name }}</td>
                                    <td>{{ $timetable->start_work_time }}</td>
                                    <td>{{ $timetable->valid_check_in_time }}-{{ $timetable->valid_check_in_time_to }}</td>
                                    <td>{{ $timetable->end_work_time }}</td>
                                    <td>{{ $timetable->overtime_start }}</td>
                                    <td>{{ $timetable->remarks ?? "-" }}</td>
                                    <td>
                                        @if($timetable->status == 1) 
                                            <a class="changeTimetableStatus" id="timetable-{{ $timetable->id }}" timetable_id="{{ $timetable->id }}" href="javascript:void(0)" title="Inactive"><i class="fas fa-toggle-on" status="Active"></i></a>  
                                        @else 
                                            <a class="changeTimetableStatus" id="timetable-{{ $timetable->id }}" timetable_id="{{ $timetable->id }}" href="javascript:void(0)" title="Active"><i class="fas fa-toggle-off" status="Inactive"></i></a> 
                                        @endif
                                    </td>
                                    <td>
                                        @can('TimeTable.Edit')
                                            <a title="Edit" class="btn btn-success text-white" href="javascript:" data-toggle="modal" data-target="#editTimetable" id="timetableEdit" data-id="{{ $timetable->id }}"><i data-feather='edit'></i></a>
                                        @endcan
                                        
                                        @can('TimeTable.Delete')
                                            <a title="Delete" class="btn btn-danger text-white deleteTimetable" href="javascript:"><i data-feather='trash-2'></i></a>

                                            <form id="timetableDeleteForm" action="{{ route('timetables.destroy', $timetable->id) }}" method="POST" style="display: none;">
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

<!-- Add New timetable modal -->
<div class="modal fade" id="addNewTimetable" tabindex="-1" role="dialog" aria-labelledby="shift" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="shift">Add New Timetable</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form action="{{ route('timetables.store') }}" method="POST" id="jquery-val-form">
                @csrf
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="timetable_name">Timetable Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('timetable_name') is-invalid @enderror" id="timetable_name" name="timetable_name" placeholder="Timetable Name" value="{{ old('timetable_name') }}" />
                        @error('timetable_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="start_work_time">Start Work Time<span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('start_work_time') is-invalid @enderror" id="start_work_time" name="start_work_time" value="{{ old('start_work_time') }}" />
                                @error('start_work_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="valid_check_in_time">Valid Check-In Time<span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('valid_check_in_time') is-invalid @enderror" id="valid_check_in_time" name="valid_check_in_time" value="{{ old('valid_check_in_time') }}" />
                                @error('valid_check_in_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="valid_check_in_time_to">To<span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('valid_check_in_time_to') is-invalid @enderror" id="valid_check_in_time_to" name="valid_check_in_time_to" value="{{ old('valid_check_in_time_to') }}" />
                                @error('valid_check_in_time_to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="end_work_time">End Work Time<span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('end_work_time') is-invalid @enderror" id="end_work_time" name="end_work_time" value="{{ old('end_work_time') }}" />
                                @error('end_work_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="valid_check_out_time">Valid Check-Out Time<span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('valid_check_out_time') is-invalid @enderror" id="valid_check_out_time" name="valid_check_out_time" value="{{ old('valid_check_out_time') }}" />
                                @error('valid_check_out_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="valid_check_out_time_to">To<span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('valid_check_out_time_to') is-invalid @enderror" id="valid_check_out_time_to" name="valid_check_out_time_to" value="{{ old('valid_check_out_time_to') }}" />
                                @error('valid_check_out_time_to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="overtime_start">Overtime Start Time<span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('overtime_start') is-invalid @enderror" id="overtime_start" name="overtime_start" value="{{ old('overtime_start') }}" />
                        @error('overtime_start')
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
                        @error('remarks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
<div class="modal fade" id="editTimetable" tabindex="-1" role="dialog" aria-labelledby="timetable" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="timetable">Edit Timetable</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form method="POST" id="timetableUpdateForm">
                
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="timetable_name">Timetable Name<span class="text-danger">*</span></label>
                        <input type="hidden" id="timetable_id" name="timetable_id" value="">
                        <input type="text" class="form-control" id="timetable_name_update" name="timetable_name" placeholder="Timetable Name" value="" />
                        
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="start_work_time">Start Work Time<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="start_work_time_update" name="start_work_time" value="" />
                                
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="valid_check_in_time">Valid Check-In Time<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="valid_check_in_time_update" name="valid_check_in_time" value="" />
                                
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="valid_check_in_time_to">To<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="valid_check_in_time_to_update" name="valid_check_in_time_to" value="" />
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="end_work_time">End Work Time<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="end_work_time_update" name="end_work_time" value="" />
                               
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="valid_check_out_time">Valid Check-Out Time<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="valid_check_out_time_update" name="valid_check_out_time" value="" />
                                
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="valid_check_out_time_to">To<span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('valid_check_out_time_to') is-invalid @enderror" id="valid_check_out_time_to_update" name="valid_check_out_time_to" value="" />
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="overtime_start">Overtime Start Time<span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="overtime_start_update" name="overtime_start" value="" />
                    </div>
                </div>

                
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks_update" name="remarks" rows="3" placeholder="Remarks"></textarea>
                    </div>
                </div>

                
                <div class="modal-footer">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="submit" value="Submit" id="timetableUpdate">Update</button>
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
        if ($('#timeTablesTable').length) {
            $('#timeTablesTable').DataTable({
                responsive: true,
                processing: true,
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            });
        }
        
        // delete timetable
        $(document).on("click", ".deleteTimetable", function(e) {
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
                    $("#timetableDeleteForm").submit();
                }
            });
        });

        // edit timetable
        $(document).on('click', '#timetableEdit', function (event) {
            event.preventDefault();
            $('#editTimetable').modal('show');
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url: "/edit-timetable",
                data: {
                    id: id
                },
                success: function(resp) {
                    if (resp.success === true) {
                        $("#timetable_id").val(resp.data.id);
                        $("#timetable_name_update").val(resp.data.timetable_name);
                        $("#start_work_time_update").val(resp.data.start_work_time);
                        $("#valid_check_in_time_update").val(resp.data.valid_check_in_time);
                        $("#valid_check_in_time_to_update").val(resp.data.valid_check_in_time_to);
                        $("#end_work_time_update").val(resp.data.end_work_time);
                        $("#valid_check_out_time_update").val(resp.data.valid_check_out_time);
                        $("#valid_check_out_time_to_update").val(resp.data.valid_check_out_time_to);
                        $("#overtime_start_update").val(resp.data.overtime_start);
                        $("#remarks_update").val(resp.data.remarks);
                    } else {
                        console.log("Error");
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        });

        // update timetable
        $(document).on('click', '#timetableUpdate', function (event) {
            event.preventDefault();
           
            $.ajax({
              url: '/update-timetable',
              type: "POST",
              data: {
                timetable_id: $("#timetable_id").val(),
                timetable_name: $("#timetable_name_update").val(),
                start_work_time: $("#start_work_time_update").val(),
                valid_check_in_time: $("#valid_check_in_time_update").val(),
                valid_check_in_time_to: $("#valid_check_in_time_to_update").val(),
                end_work_time: $("#end_work_time_update").val(),
                valid_check_out_time: $("#valid_check_out_time_update").val(),
                valid_check_out_time_to: $("#valid_check_out_time_to_update").val(),
                overtime_start: $("#overtime_start_update").val(),
                remarks: $("#remarks_update").val(),
              },
              success: function (resp) {
                if (resp.success === true) {
                    $('#timetableUpdateForm').trigger("reset");
                    $('#editTimetable').modal('hide');
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

        // change timetable status
        $(document).on("click", ".changeTimetableStatus", function(){
            var status = $(this).children("i").attr("status");
            var timetable_id = $(this).attr("timetable_id");
            
            $.ajax({
                type: 'POST',
                url: '/timetable-status',
                data: {status:status, timetable_id:timetable_id},
                success: function(resp){
                    if(resp['status'] == 0){
                        $("#timetable-"+timetable_id).html("<i class='fas fa-toggle-off' status='Inactive'></i>");
                    } else if(resp['status'] == 1){
                        $("#timetable-"+timetable_id).html("<i class='fas fa-toggle-on' status='Active'></i>");
                    }
                },
                error: function(){
                    console.log("Error");
                }
            });
        });
    </script>
@endpush