<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ShiftTimetableController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Admin\BreakTimeController;
use App\Http\Controllers\FallbackController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Admin route
Route::group([], function () {
    Route::group(['middleware' => ['auth', 'admin']], function () {
        // dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.view');
        // logout
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        // change password
        Route::post('change-password', [AuthController::class, 'changePassword']);
        // profile image change
        Route::post('change-profile-image', [AuthController::class, 'changeProfileImage']);
        // profile
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        // role and permissions management
        Route::post('delete-role', [RoleController::class, 'roleDelete'])->name('role.delete');
        Route::resource('roles', RoleController::class)->except(['destroy']);
        // users management
        Route::post('delete-user', [UserController::class, 'userDelete'])->name('user.delete');
        Route::post('user-status', [UserController::class, 'changeUserStatus'])->name('user.status');
        Route::resource('users', UserController::class)->except(['destroy']);
        // attendance report
        Route::match(['get', 'post'], 'report', [AttendanceController::class, 'report'])->name('attendance.report');
        // department
        Route::get('edit-department', [DepartmentController::class, 'editDepartment'])->name('department.edit');
        Route::post('update-department', [DepartmentController::class, 'updateDepartment'])->name('department.update');
        Route::post('department-status', [DepartmentController::class, 'changeDepartmentStatus'])->name('department.status');
        Route::resource('departments', DepartmentController::class)->except(['show', 'edit', 'update']);
        // timetable
        Route::get('edit-timetable', [TimetableController::class, 'editTimetable'])->name('timetable.edit');
        Route::post('update-timetable', [TimetableController::class, 'updateTimetable'])->name('timetable.update');
        Route::post('timetable-status', [TimetableController::class, 'changeTimetableStatus'])->name('timetable.status');
        Route::resource('timetables', TimetableController::class)->except(['show', 'edit', 'update']);
        // shift
        Route::get('edit-shift', [ShiftTimetableController::class, 'editShift'])->name('shift.edit');
        Route::post('update-shift', [ShiftTimetableController::class, 'updateShift'])->name('shift.update');
        Route::post('shift-status', [ShiftTimetableController::class, 'changeShiftStatus'])->name('shift.status');
        Route::resource('shifts', ShiftTimetableController::class);
        // employees
        Route::post('employee-status', [EmployeeController::class, 'changeEmployeeStatus'])->name('employee.status');
        Route::resource('employees', EmployeeController::class);
    });
    // login
    Route::match(['get', 'post'], 'hr/admin', [AuthController::class, 'login'])->name('login');
    // forgot password
    Route::match(['get', 'post'], 'forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
    Route::get('reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('reset-password-form');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
});

// show 404 page if route not found
Route::fallback(FallbackController::class);
