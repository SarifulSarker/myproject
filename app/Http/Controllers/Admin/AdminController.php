<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function admin()
    {
        return view('admin.home');
    }

    //admin logout
    public function adminlogout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }

    //password change
    public function passwordchange(){
        return view('admin.profile.password_change');
    }

        //password Update
        public function PasswordUpdate(Request $request)
        {
            $validated = $request->validate([
               'old_password' => 'required',
               'password' => 'required|min:6|confirmed',
            ]);

            $current_password=Auth::user()->password;  //login user password get


            $oldpass=$request->old_password;  //oldpassword get from input field
            $new_password=$request->password;  // newpassword get for new password
            if (Hash::check($oldpass,$current_password)) {  //checking oldpassword and currentuser password same or not
                   $user=User::findorfail(Auth::id());    //current user data get
                   $user->password=Hash::make($request->password); //current user password hasing
                   $user->save();  //finally save the password
                   Auth::logout();  //logout the admin user anmd redirect admin login panel not user login panel
                  // $notification=array('messege' => 'Your Password Changed!', 'alert-type' => 'success');
                  Toastr::success(' Password Change Successfully!');
                   return redirect()->route('admin.login')->with($notification);
            }else{
               // $notification=array('messege' => 'Old Password Not Matched!', 'alert-type' => 'error');
               Toastr::success('Old Password Not Matched!!');
                return redirect()->back();
            }
        }


}
