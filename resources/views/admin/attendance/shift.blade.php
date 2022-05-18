@extends('admin.master')

@section('title', 'Shifts')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-8">
                    <h2 class="content-header-title float-left">Shifts</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.view')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">All Shifts
                            </li>
                        </ol>
                    </div>
                </div>
                @can('Shift.Create')
                    <div class="col-4">
                        <button class="btn btn-primary text-white float-right" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-toggle="modal" data-target="#addNewShift">
                            <span>
                                <i class="far fa-plus-square"></i>
                                Add New Shift
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
                        <table class="datatables-basic table text-center" id="shiftTable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Shift Name</th>
                                    <th>Timetable</th>
                                    <th>Start Work Time</th>
                                    <th>End Work Time</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($shifts as $shift)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $shift->shift_name }}</td>
                                    <td>{{ $shift->timetable->timetable_name }}</td>
                                    <td>{{ $shift->timetable->start_work_time }}</td>
                                    <td>{{ $shift->timetable->end_work_time }}</td>
                                    <td>{{ $shift->remarks ?? "-" }}</td>
                                    <td>
                                        @if($shift->status == 1) 
                                            <a class="changeShiftStatus" id="shift-{{ $shift->id }}" shift_id="{{ $shift->id }}" href="javascript:void(0)" title="Inactive"><i class="fas fa-toggle-on" status="Active"></i></a>  
                                        @else 
                                            <a class="changeShiftStatus" id="shift-{{ $shift->id }}" shift_id="{{ $shift->id }}" href="javascript:void(0)" title="Active"><i class="fas fa-toggle-off" status="Inactive"></i></a> 
                                        @endif
                                    </td>
                                    <td>
                                        @can('Shift.Edit')
                                            <a title="Edit" class="btn btn-success text-white" href="javascript:" data-toggle="modal" data-target="#editShift" id="shiftEdit" data-id="{{ $shift->id }}"><i data-feather='edit'></i></a>
                                        @endcan
                                        
                                        @can('Shift.Delete')
                                            <a title="Delete" class="btn btn-danger text-white deleteShift" href="javascript:"><i data-feather='trash-2'></i></a>

                                            <form id="shiftDeleteForm" action="{{ route('shifts.destroy', $shift->id) }}" method="POST" style="display: none;">
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

<!-- Add New shift modal -->
<div class="modal fade text-left" id="addNewShift" tabindex="-1" role="dialog" aria-labelledby="shift" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="shift">Add New Shift</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('shifts.store') }}" method="POST" id="jquery-val-form">
                @csrf
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="shift_name">Shift Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('shift_name') is-invalid @enderror" id="shift_name" name="shift_name" placeholder="Shift Name" value="{{ old('shift_name') }}" />
                        @error('shift_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                
                <div class="col-12">
                    <div class="form-group">
                        <label for="roles">Assign Timetable<span class="text-danger">*</span></label>
                        <select name="timetable_id" id="timetable" class="form-control select2">
                        <option value="">Select Timetable</option>
                            @foreach ($timetables as $timetable)
                                <option value="{{ $timetable->id }}">{{ $timetable->timetable_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="name">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Remarks"></textarea>
                        @error('shift_name')
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

<!-- Edit shift modal -->
<div class="modal fade text-left" id="editShift" tabindex="-1" role="dialog" aria-labelledby="shiftEditss" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="shiftEditss">Edit Shift</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="shiftUpdateFrom">

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="shift_name">Shift Name<span class="text-danger">*</span></label>
                        <input type="hidden" id="shift_id_update" name="shift_id" value="">
                        <input type="text" class="form-control" id="shift_name_update" name="shift_name" placeholder="Shift Name" value="" />
                    </div>
                </div>

                
                <div class="col-12">
                    <div class="form-group">
                        <label for="roles">Assign Timetable<span class="text-danger">*</span></label>

                        <select name="timetable_id" id="timetable_id_update" class="form-control select2"></select>

                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="name">Remarks</label>
                        <textarea class="form-control" id="remarks_update" name="remarks" rows="3" placeholder="Remarks"></textarea>
                    </div>
                </div>

                
                <div class="modal-footer">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="submit" value="Submit" id="shiftUpdateBtn">Submit</button>
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
        if ($('#shiftTable').length) {
            $('#shiftTable').DataTable({
                responsive: true,
                processing: true,
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            });
        }
        
        // delete shift
        $(document).on("click", ".deleteShift", function(e) {
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
                    $("#shiftDeleteForm").submit();
                }
            });
        });

        // edit timetable
        $(document).on('click', '#shiftEdit', function (event) {
            event.preventDefault();
            $('#editShift').modal('show');
            var id = $(this).data('id');

            $("#timetable_id_update").html("");

            $.ajax({
                type: "GET",
                url: "/edit-shift",
                data: {
                    id: id
                },
                success: function(resp) {
                    if (resp.success === true) {
                        $("#shift_id_update").val(resp.data.id);
                        $("#shift_name_update").val(resp.data.shift_name);
                        $("#timetable_id_update").val(resp.data.timetable_id);
                        $("#remarks_update").val(resp.data.remarks);

                        $.each(resp.timetables, function(key, value) {
                            $("#timetable_id_update").append(
                                '<option value="' +
                                    value.id +
                                    '"' +
                                    (value.id == resp.data.timetable_id ? 'selected="selected"' : "") +
                                    ">" +
                                    value.timetable_name +
                                    "</option>"
                            );
                        });

                    } else {
                        console.log("Error");
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        });

        // update shift
        $(document).on('click', '#shiftUpdateBtn', function (event) {
            event.preventDefault();
           
            $.ajax({
              url: '/update-shift',
              type: "POST",
              data: {
                shift_id: $("#shift_id_update").val(),
                shift_name: $("#shift_name_update").val(),
                timetable_id: $("#timetable_id_update").val(),
                remarks: $("#remarks_update").val(),
              },
              success: function (resp) {
                if (resp.success === true) {
                    $('#shiftUpdateFrom').trigger("reset");
                    $('#editShift').modal('hide');
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

        // change shift status
        $(document).on("click", ".changeShiftStatus", function(){
            var status = $(this).children("i").attr("status");
            var shift_id = $(this).attr("shift_id");
            
            $.ajax({
                type: 'POST',
                url: '/shift-status',
                data: {status:status, shift_id:shift_id},
                success: function(resp){
                    if(resp['status'] == 0){
                        $("#shift-"+shift_id).html("<i class='fas fa-toggle-off' status='Inactive'></i>");
                    } else if(resp['status'] == 1){
                        $("#shift-"+shift_id).html("<i class='fas fa-toggle-on' status='Active'></i>");
                    }
                },
                error: function(){
                    console.log("Error");
                }
            });
        });
    </script>
@endpush