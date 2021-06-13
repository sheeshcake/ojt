<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Redirect;

class DeanController extends Controller
{
    public function index(){
        return view("layouts.dean.dashboard")->with("dashboard", "active");
    }
    public function dologout(){
        Auth::guard('dean')->logout();
        Session()->flush();
    
        return Redirect::to('/');
    }
}
