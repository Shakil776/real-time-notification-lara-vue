<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('Role.View')) {
            return view('errors.403');
        }

        $roles = Role::orderBy('id','ASC')->get();
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        if (is_null($this->user) || !$this->user->can('Role.Create')) {
            return view('errors.403');
        }

        $all_permissions  = Permission::get();
        $permission_groups = User::getpermissionGroups();
        return view('admin.role.create', compact('all_permissions', 'permission_groups'));
    }

    public function store(Request $request)
    {   
        if (is_null($this->user) || !$this->user->can('Role.Create')) {
            return view('errors.403');
        }

        // Validation Data
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // process Data
        $role = Role::create(['name' => $request->input('name')]);

        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        toastr()->success('Role created successfully.', 'Success!');
        return redirect()->route('roles.index');
    }

    public function edit($id) {
        if (is_null($this->user) || !$this->user->can('Role.Edit')) {
            return view('errors.403');
        }

        $role = Role::find($id);
        $all_permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.role.edit', compact('role', 'all_permissions', 'permission_groups'));
    }

    public function update(Request $request, $id) {
        if (is_null($this->user) || !$this->user->can('Role.Edit')) {
            return view('errors.403');
        }

        // Validation Data
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:roles,name,' . $id,
            'permissions' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permissions'));
        
        toastr()->success('Role updated successfully.', 'Success!');
        return redirect()->route('roles.index');
    }

    // delete role
    public function roleDelete(Request $request) {
        if (is_null($this->user) || !$this->user->can('Role.Delete')) {
            return view('errors.403');
        }

        if ($request->ajax()) {
            $data = $request->all();

            $role = Role::find($data['id']);
            if (!is_null($role)) {
                $role->delete();
            }

            toastr()->success('Role deleted successfully.', 'Success!');

            return response()->json([
                'success' => true,
            ]);
        }
    }
}
