<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index(){
        return view('login');
    }

    function login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ],[
            'username.required'=>'Username Wajib Diisi',
            'password.required'=>'Password Wajib Diisi'
        ]);

        $infologin =[
            'username'=>$request->username,
            "password"=> $request->password
        ];

        if(Auth::attempt($infologin)){
            if(Auth::user()->role == 'admin'){
                return redirect('user/admin');
            } else if(Auth::user()->role == 'manager'){
                return redirect('user/manager');
            } else if(Auth::user()->role == 'owner'){
                return redirect('user/owner');
            }
        }else{
            return redirect("")->withErrors('Username dan password tidak sesuai')->withInput();
        }
    }

    function logout(){
        Auth::logout();
        return redirect('');
    }
}
