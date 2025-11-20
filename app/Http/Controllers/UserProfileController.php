<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pets = Pet::where('User_ID', $user->ID_User)->get();
        return view('profile', compact('user', 'pets'));
    }

    public function addPet(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|min:2',
            'Breed' => 'required|string|max:100',
            'breed_category' => 'required|string|max:50'
        ]);
        Pet::create([
            'User_ID' => Auth::user()->ID_User,
            'Name' => $request->input('Name'),
            'Breed' => $request->input('Breed'),
            'breed_category' => $request->input('breed_category')
        ]);
        return redirect()->route('profile')->with('success', 'Питомец добавлен!');
    }

    public function deletePet($id)
    {
        $userId = Auth::user()->ID_User;
        Pet::where('ID', $id)->where('User_ID', $userId)->delete();
        return redirect()->route('profile')->with('success', 'Питомец удалён!');
    }

    public function editUser(Request $request)
    {
        $user = Auth::user();
        $field = $request->input('field');

        if ($field === 'Login') {
            $request->validate([
                'Login' => 'required|string|max:100|unique:users,Login,' . $user->ID_User . ',ID_User'
            ]);
            $user->Login = $request->input('Login');
        } elseif ($field === 'Avatar_url') {
            $request->validate([
                'Avatar_url' => 'required|email|max:100|unique:users,Avatar_url,' . $user->ID_User . ',ID_User'
            ]);
            $user->Avatar_url = $request->input('Avatar_url');
        } elseif ($field === 'Password') {
            $request->validate([
                'Password' => 'required|min:6|confirmed'
            ]);
            $user->Password = Hash::make($request->input('Password'));
        } elseif ($field === 'photo_url') {
            if ($request->hasFile('photo_url')) {
                $path = $request->file('photo_url')->store('avatars', 'public');
                $user->photo_url = $path;
            }
        }
        $user->save();
        return redirect()->route('profile')->with('success', 'Данные успешно обновлены!');
    }
}
