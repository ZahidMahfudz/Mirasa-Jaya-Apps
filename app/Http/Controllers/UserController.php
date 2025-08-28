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
        return redirect('user/admin/KelolaAkun');
    }
    function manager(){
        // return view('manager.dashboard');
        return redirect('user/manager/resumeproduksi');
    }
    function owner(){
        // return view('owner.dashboard');
        return redirect('user/owner/laporanproduksi');
    }

    function pemasaran(){
        return redirect('user/pemasaran/dasboard');
    }
}
