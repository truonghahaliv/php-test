<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();
        return view("users.index",["users"=>$users]);
      
    }
    public function create(){
        return view("users.create");
    }
    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
           
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        $newUser = User::create($data);

        return redirect(route('user.index'));

    }
    public function edit(User $user){
        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user, Request $request){
        $data = $request->validate([
            'name' => 'required',
           
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required'
        ]);

        $user->update($data);

        return redirect(route('user.index'))->with('success', 'User Updated Succesffully');

    }
    public function destroy(User $User){
        $User->delete();
        return redirect(route('user.index'))->with('success', 'User deleted Succesffully');
    }
    
}
