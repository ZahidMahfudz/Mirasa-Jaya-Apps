<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index(){
        echo "<h1>Anda Tidak Diperkenankan Menerobos</h1>";
        echo "<a href='/logout'>Logout</a>";
    }
    function admin(){
        return view('admin.layout');
    }
    function manager(){
        return view('manager.dashboard');
    }
    function owner(){
        return view('owner.dashboard');
    }
}
