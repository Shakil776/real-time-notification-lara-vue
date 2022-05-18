@extends('admin.master')

@section('title', 'Roles')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-8">
                    <h2 class="content-header-title float-left">Roles</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.view')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">All Role
                            </li>
                        </ol>
                    </div>
                </div>
                @can('Role.Create')
                    <div class="col-4">
                        <a class="btn btn-primary text-white float-right" href="{{ route('roles.create') }}">Create New Role</a>
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
                        <table class="datatables-basic table" id="rolesTable">
                            <thead>
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="15%">Name</th>
                                    <th width="60%">Permissions</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($roles as $role)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td class="text-justify">
                                        @foreach ($role->permissions as $perm)
                                            <span class="badge badge-light mb-1" style="color:#000;">
                                                {{ $perm->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    
                                    <td>
                                        
                                        @can('Role.Edit')
                                            <a title="Edit" class="btn btn-success text-white" href="{{ route('roles.edit', $role->id) }}"><i data-feather='edit'></i></a>
                                        @endcan

                                        @can('Role.Delete')
                                            <a title="Delete" class="btn btn-danger text-white deleteRole" id="{{ $role->id }}" href="javascript:"><i data-feather='trash-2'></i></a>
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
    <script>
        // datatable init
        if ($('#rolesTable').length) {
            $('#rolesTable').DataTable({
                responsive: true,
                processing: true,
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            });
        }

        // delete user
        $(document).on("click", ".deleteRole", function(e) {
            e.preventDefault();
            var id = $(this).attr("id");
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

                    $.ajax({
                        type: "post",
                        url: "{{ route('role.delete') }}",
                        data: { id: id },
                        success: function(resp) {
                            if (resp.success === true) {
                                window.location.reload(true);
                            } else {
                                // show error message
                                iziToast.show({
                                    title: "Opppps!",
                                    position: "topRight",
                                    timeout: 2000,
                                    color: "red",
                                    message: "Something Wrong. Please try again.",
                                    messageColor: "black"
                                });
                            }
                        },
                        error: function() {
                            console.log("Error");
                        }
                    });
                }
            });
        });
    </script>
@endpush
