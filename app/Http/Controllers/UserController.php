<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $registerFields = $request->validate([
            'username' => 'required|min:3|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);
        $registerFields['password'] = bcrypt($registerFields['password']);
        $user = User::create($registerFields);
        auth()->login($user);

        return redirect('/')->with('success', 'Thanks you for creating an account!');
    }

    public function login(Request $request)
    {
        $loginFields = $request->validate([
           'loginusername' => 'required',
           'loginpassword' => 'required'
        ]);

        if(auth()->attempt([
            'username' => $loginFields['loginusername'],
            'password' => $loginFields['loginpassword']
        ])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You have successfully logged in!');
        } else {
            return redirect('/')->with('error', 'Invalid login credentials');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out');
    }

    public function showCorrectHomepage()
    {
        if(auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }
}
