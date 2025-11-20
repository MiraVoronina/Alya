<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create()
    {
        // Все питомцы пользователя
        $pets = Pet::where('user_id', Auth::id())->get();
        return view('appointments.create', compact('pets'));
    }

    public function store(Request $request)
    {
        $appointment = new Appointment();
        $appointment->User_ID = Auth::id();
        $appointment->Pets_ID = $request->input('pet_id');
        $appointment->Date = $request->input('date');
        $appointment->Time = $request->input('time');
        $appointment->master = $request->input('master');
        $appointment->ID_status = 1;

        $appointment->save();

        return redirect()->route('appointments.index');
    }

    public function index()
    {
        $appointments = Appointment::where('User_ID', Auth::id())->get();
        return view('appointments.index', compact('appointments'));
    }

}
