<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    function getLogin(){
        return view('backend.login.login');
    }
    function postLogin(LoginRequest $r){
        $email = $r->email;
        $password = $r->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('admin');
        }
        else {
            return redirect()->back()->with(['notify' => 'email or password was incorrect'])->withInput();
            //withInput(): still display email when password is not correct
        }
    }
    function getLogout(){
        Auth::logout();
        return redirect('/login');
    }
}
