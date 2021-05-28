<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dean;

use Auth;

class DeanLoginController extends Controller
{
    public function index(){
        return view('auth.deanlogin');
    }

    public function dologin(Request $request){
        $credentials = $request->only('username', 'password');
        if(Auth::guard('dean')->attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route("dean.dashboard"));
        }else{
            return back()->with("msg", "Wrong Username or Password");
        }
    }
}
