<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:users');
    }
    public function registerUser(Request $request)
    {
        $this->validate($request,[
            'username' => 'required|email',
            'password' => 'required|min:6',
        ]);
    }
    public function showLoginFormUser()
    {
    return view('user.register');
    }
    public function loginUser(Request $request)
    {

    }
}
