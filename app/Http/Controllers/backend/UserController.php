<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\User;

class UserController extends Controller
{
    function getUser(){
        $data['users'] = User::paginate(10);
        return view('backend.user.listuser', $data);
    }
    function getAddUser(){
        return view('backend.user.adduser');

    }
    function postAddUser(AddUserRequest $r){
        $user = new User();
        $user->email = $r->email;
        $user->password = $r->password;
        $user->full = $r->full;
        $user->address= $r->address;
        $user->phone = $r->phone;
        $user->level = $r->level;
        $user->save();

        return redirect('/admin/user')->with('notify', 'Add user successfully!');
    }

    function getEditUser($idUser, request $r){
        $data['user'] = User::find($idUser);
        
        return view('backend.user.edituser', $data);

    }
    function postEditUser($idUser, EditUserRequest $r){
        $user = User::find($idUser);
        $user->email = $r->email;
        if($r->password!='')
        {
            $user->password = bcript($r->password);
        }
      
        $user->full = $r->full;
        $user->address= $r->address;
        $user->phone = $r->phone;
        $user->level = $r->level;
        $user->save();

        return redirect('/admin/user')->with('notify', 'Edit user successfully!');
    }

    function getDelUser($idUser){
        User::find($idUser)->delete();
        return redirect('/admin/user');
    }
}
