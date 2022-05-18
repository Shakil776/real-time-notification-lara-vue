<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Jobs\ForgotPasswordJob;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('admin', ['except' => [
            'login', 'forgetPassword', 'resetPasswordForm', 'resetPassword'
        ]]);
    }

    // login
    public function login(Request $request) {

        if ($request->isMethod('POST')) {
            $data = $request->all();
            $remember = (!empty($data['remember'])) ? true : false;

            $validator = Validator::make(
                [
                    'email'    => $data['email'],
                    'password' => $data['password'],
                ],
                [
                    'email'    => "required|email",
                    'password' => "required",
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $credential = [
                    'email'       => $data['email'],
                    'password'    => $data['password']
                ];

                if (Auth::attempt($credential, $remember)) {
                    // retuen admin dashboard
                    return redirect()->intended(route('dashboard.view'));
                } else {
                    $error_message = "Invalid Credentials!";
                    return redirect()->back()->withErrors($error_message)->withInput();
                }
            }
        }

        if (Auth::check()) {
            return redirect()->route('dashboard.view');
        }

        return view('admin.auth.login');
    }
    // logout
    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

    // profile
    public function profile() {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::where(['id' => $user_id])->first()->toArray();
        }
        return view('admin.user.profile', compact('user')); 
    }

    // forget password
    public function forgetPassword(Request $request) {
        if ($request->isMethod('POST')) {
            
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // save password resets table
            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email'      => $request->email,
                'token'      => $token,
                'created_at' => Carbon::now(),
            ]);

            // send mail usign job queue
            dispatch(new ForgotPasswordJob($request->email, $token));
            return back()->with('success', 'We have Emailed your password reset link! Please Check your email.');
        }
        return view('admin.auth.forget_password');
    }

    // reset password form
    public function resetPasswordForm($token) {
        return view('admin.auth.reset_password', ['token' => $token]);
    }

    public function resetPassword(Request $request) {
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'email'                 => 'required|email|exists:users',
                'password' => [
                    'required',
                    Password::min(6)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
                'password_confirmation' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

            if (!$updatePassword) {
                return back()->withInput()->with('error', 'Invalid token!');
            }

            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['email' => $request->email])->delete();

            return redirect()->route('login')->with('success', 'Your password has been changed!');
        }
    }

    // change password
    public function changePassword(Request $request) {
        if ($request->ajax()) {

            $data = Validator::make($request->all(), [
                'current_password'      => 'required',
                'new_password' => [
                    'required',
                    Password::min(6)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
                'password_confirmation' => 'required|same:new_password',
            ]);

            if ($data->fails()) {
                return response()->json(['errors' => $data->errors()->all()]);
            }

            if (Auth::check()) {
                $user = Auth::user();
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'error'   => true,
                    'message' => 'Current password does not match!',
                ]);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json([
                'error'   => false,
                'message' => 'Password changed Successfully !',
            ]);
        }
    }

    // change profile image
    public function changeProfileImage(Request $request) {

        if ($request->ajax()) {

            $data = Validator::make($request->all(), [
                'image' => 'required|base64image|base64mimes:jpeg,png,jpg|base64max:500',
            ]);

            if ($data->fails()) {
                return response()->json(['errors' => $data->errors()->all()]);
            }

            if (Auth::check()) {
                $user = Auth::user();
            }

            // upload profile image
            if ($image_64 = $request->image) {
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $fileName = rand(111, 99999).time() . '_' . $user->id . '.' . $extension;
                $imagePath = 'uploads/profileImage/'.$fileName;                
                // upload new image
                Image::make(base64_decode($image))->save($imagePath);
                // update profile image
                User::where('id', $user->id)->update(['image' => $fileName]);

                return response()->json([
                    'success' => true,
                    'message' => 'Profile photo changed successfully.',
                ]);
            }

        }
    }
}
