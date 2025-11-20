<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:100|unique:users,Login',
            'email' => 'required|email|max:100|unique:users,Avatar_url',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'Login' => $request->login,
            'Avatar_url' => $request->email,
            'Password' => Hash::make($request->password),
            'role' => 'user',
            'ID_User_Role' => 2
        ]);

        auth()->login($user);

        return redirect('/');
    }
}
