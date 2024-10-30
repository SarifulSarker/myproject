<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('email' =>$request->email, 'password' =>$request->password))){

            if(auth()->user()->is_admin == 1){
                    return redirect()->route('admin.home');
            }else{
                  return redirect()->route('home');
            }
        }
        else{
            return redirect()->back()->withmessage('error', 'wrong email password');
        }
    }

    //admin login form
    public function adminlogin(){
        return view('auth.admin_login');
    }
}
