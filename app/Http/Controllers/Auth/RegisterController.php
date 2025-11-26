<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register'); // Важно: 'register', файл лежит в resources/views/register.blade.php
    }

    public function register(RegisterRequest $request)
    {
        $avatarUrl = null;
        if ($request->hasFile('photo')) {
            $avatarUrl = $request->file('photo')->store('avatars', 'public');
        }

        $user = User::create([
            'Login' => $request->login,
            'Avatar_url' => $avatarUrl, // фикс
            'Password' => Hash::make($request->password),
            'role' => 'user',
            'ID_User_Role' => 2,
            'Pets_id' => null,
        ]);

        auth()->login($user);
        return redirect()->route('home')->with('status', 'Регистрация успешно завершена');
    }
}
