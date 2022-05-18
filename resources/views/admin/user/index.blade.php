@extends('admin.master')

@section('title', 'Users')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-8">
                    <h2 class="content-header-title float-left">Users</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.view')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">All Users
                            </li>
                        </ol>
                    </div>
                </div>
                @can('User.Create')
                    <div class="col-4">
                        <a class="btn btn-primary text-white float-right" href="{{ route('users.create') }}">Create New User</a>
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
                        <table class="datatables-basic table text-center" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Roles</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($users as $user)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if(!empty($user->image))
                                            <img src="{{ asset('uploads/profileImage/'.$user->image) }}" alt="User Image" width="60">
                                        @else
                                            <img src="{{ asset('admin/assets/img/default.png') }}" alt="User Image" width="60">
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="badge badge-info mr-1">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($user->status == 1) 
                                            <a class="changeUserStatus" id="user-{{ $user->id }}" user_id="{{ $user->id }}" href="javascript:void(0)" title="Inactive"><i class="fas fa-toggle-on" status="Active"></i></a>  
                                        @else 
                                            <a class="changeUserStatus" id="user-{{ $user->id }}" user_id="{{ $user->id }}" href="javascript:void(0)" title="Active"><i class="fas fa-toggle-off" status="Inactive"></i></a> 
                                        @endif
                                    </td>
                                    <td>
                                       
                                        @can('User.Edit')
                                            <a title="Edit" class="btn btn-success text-white" href="{{ route('users.edit', $user->id) }}"><i data-feather='edit'></i></a>
                                        @endcan
                                        
                                        @can('User.Delete')
                                            <a title="Delete" class="btn btn-danger text-white deleteUser" id="{{ $user->id }}" href="javascript:"><i data-feather='trash-2'></i></a>
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
    @include('admin.user.users_js')
@endpush