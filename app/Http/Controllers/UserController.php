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
        User::create($registerFields);
        return "Hello";
    }
}
