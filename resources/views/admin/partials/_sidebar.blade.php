@php
    $user = Auth::user();
@endphp

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('dashboard.view') }}">
                <img class="img-fluid" src="{{ asset('admin/assets/img/logo.png') }}" alt="Login" width="25px"/>
                <h2 class="brand-text">Sukhtara HR</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <!-- dashboard start -->
            @if ($user->can('Dashboard.View'))
                <li class="nav-item">
                    <li class="{{ Route::is('dashboard.view') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('dashboard.view') }}"><i data-feather="home"></i><span class="menu-item text-truncate" data-i18n="Dashboards">Dashboard</span></a>
                        </li>
                </li>
            @endif
            <!-- dashboard end -->

            <!-- Employee module start -->
            @if ($user->can('Employee.View') || $user->can('Department.View') || $user->can('TimeTable.View') || $user->can('Shift.View'))
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="copy"></i><span class="menu-title text-truncate" data-i18n="Form Elements">Manage Employee</span></a>
                    <ul class="menu-content">
                        @if ($user->can('Department.View'))
                            <li class="{{ Route::is('departments.index') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('departments.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input">Department</span></a>
                            </li>
                        @endif

                        @if ($user->can('TimeTable.View'))
                            <li class="{{ Route::is('timetables.index') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('timetables.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input">Timetable</span></a>
                            </li>
                        @endif

                        @if ($user->can('Shift.View'))
                            <li class="{{ Route::is('shifts.index') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('shifts.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input">Shift</span></a>
                            </li>
                        @endif

                        @if ($user->can('Employee.View'))
                            <li class="{{ Route::is('employees.index') || Route::is('employees.create') || Route::is('employees.edit') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('employees.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input">Employee</span></a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <!-- Employee module end -->

            <!-- Attendance report Module start -->
            @if ($user->can('AttendanceReport.View'))
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="copy"></i><span class="menu-title text-truncate" data-i18n="Form Elements">Attendance Report</span></a>
                    <ul class="menu-content">

                        @if ($user->can('AttendanceReport.View'))
                            <li class="{{ Route::is('attendance.report') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('attendance.report') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Input">Report</span></a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <!-- Attendance Module end -->

            <!-- Role and permission management module start -->
            @if ($user->can('Role.View') || $user->can('User.View'))
                <li class=" navigation-header"><span data-i18n="User Interface">User Role and Permission</span><i data-feather="more-horizontal"></i>
                </li>
            @endif
            <!-- Role and permission management -->
            @if ($user->can('Role.Create') || $user->can('Role.View') || $user->can('Role.Edit') || $user->can('Role.Delete'))
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='lock'></i></i><span class="menu-title text-truncate" data-i18n="Card">Roles & Permissions Management</span></a>
                    <ul class="menu-content">
                        @if ($user->can('Role.Create'))
                            <li class="{{ Route::is('roles.create') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('roles.create') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Basic">Create Role</span></a>
                            </li>
                        @endif

                        @if ($user->can('Role.View'))
                            <li class="{{ Route::is('roles.index') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('roles.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Advance">All Roles</span></a>
                            </li>
                        @endif
                    </ul>
                </li> 
            @endif
            
            <!-- User management -->
            @if ($user->can('User.Create') || $user->can('User.View') || $user->can('User.Edit') || $user->can('User.Delete'))
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Card">User Management</span></a>
                    <ul class="menu-content">
                        @if ($user->can('User.Create'))
                            <li class="{{ Route::is('users.create') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('users.create') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Basic">Create User</span></a>
                            </li>
                        @endif
                        
                        @if ($user->can('User.View'))
                            <li class="{{ Route::is('users.index') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('users.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Advance">All Users</span></a>
                            </li>
                        @endif
                    </ul>
                </li> 
            @endif
            <!-- Role and permission management end -->
        </ul>
    </div>
</div>