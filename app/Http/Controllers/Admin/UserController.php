<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
    public $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('User.View')) {
            return view('errors.403');
        }

        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        if (is_null($this->user) || !$this->user->can('User.Create')) {
            return view('errors.403');
        } 

        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('User.Create')) {
            return view('errors.403');
        } 

        // Validation Data
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users',
            'mobile' => 'required',
            'password' => [
                'required',
                'string',
                Password::min(6)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed'
            ],
            'roles' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // upload image
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            if($image_tmp->isValid()){
                $file_name = $image_tmp->getClientOriginalName();
                $image_name = pathinfo($file_name, PATHINFO_FILENAME);
                $extension = $image_tmp->getClientOriginalExtension();
                $imageName =  rand(111, 99999).time().'.'.$extension;
                $imagePath = 'uploads/profileImage/'.$imageName;
                Image::make($image_tmp)->resize(300, 300)->save($imagePath);
            }
        }

        // Create New User
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['created_by'] = Auth::user()->id;
        if(!empty($imageName)){
            $input['image'] = $imageName;
        }

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        toastr()->success('User created Successfully.', 'Success!');
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('User.Edit')) {
            return view('errors.403');
        }

        $user = User::find($id);
        $roles  = Role::all();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('User.Edit')) {
            return view('errors.403');
        }

        // Validation Data
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'mobile' => 'required',
            'roles' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();
        $user = User::find($id);

        $user->update($input);

        $user->roles()->detach();
        $user->assignRole($request->input('roles'));
        
        toastr()->success('User updated successfully.', 'Success!');
        return redirect()->route('users.index');
    }


    // delete user
    public function userDelete(Request $request) {
        if (is_null($this->user) || !$this->user->can('User.Delete')) {
            return view('errors.403');
        }

        if ($request->ajax()) {
            $data = $request->all();

            $user = User::find($data['id']);
            if (!is_null($user)) {
                $user->delete();
            }

            toastr()->success('User deleted successfully.', 'Success!');

            return response()->json([
                'success' => true,
            ]);
        }
    }

    // change user status
    public function changeUserStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();

            if($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }
            User::where('id', $data['user_id'])->update(['status'=>$status]);

            return response()->json([
                'status' => $status,
                'user_id' => $data['user_id']
            ]);
        }
    }

}
