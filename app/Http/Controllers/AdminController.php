<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Redirect;

class AdminController extends Controller
{
    public function index(){
        return view("layouts.admin.dashboard")->with("dashboard", "active");
    }

    public function dologout(){
        Auth::guard('admin')->logout();
        Session()->flush();
    
        return Redirect::to('/');
    }
}
