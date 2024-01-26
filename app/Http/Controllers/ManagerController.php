<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    function dashboard(){
        return view('manager.dashboard');
    }
}
