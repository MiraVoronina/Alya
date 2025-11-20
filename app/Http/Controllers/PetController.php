<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::where('user_id', Auth::id())->get();
        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        Pet::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'breed' => $request->breed,
        ]);
        return redirect()->route('pets.index');
    }
}
