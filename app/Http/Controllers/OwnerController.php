<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerController extends Controller
{
    function dashboard(){
        return view('owner.dashboard');
    }
}
