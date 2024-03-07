<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class wipController extends Controller
{
    public function index(){
        return view('manager.wip');
    }
}
