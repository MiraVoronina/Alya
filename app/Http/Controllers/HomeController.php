<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('Created_at', 'desc')->get();
        return view('home', compact('promotions'));
    }
}
