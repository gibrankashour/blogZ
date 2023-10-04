<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
    
    public function showLoginForm(){
        if(auth()->guard('web')->check()) {
            return redirect()->route('login.error');
        }
        return view('backend.login');
    }

    public function login(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if($validator->fails()) {
            return redirect()->route('admin.login')->withInput()->withErrors($validator);
        }

        $remember_me = $request->has('remember') ? true : false;

        if (Auth::guard('admin')->attempt([
            'email' => $request->input("email"),
            'password' => $request->input("password"),
            'admin' => 1
            ], $remember_me)) {

            $request->session()->regenerate();  
            //dd($request);   
            // notify()->success('تم الدخول بنجاح  ');
            return redirect()->route('admin.home');
        }
        // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->route('admin.login')->withErrors(['email' => __('auth.failed')]);

    }


    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');

    }

}
