<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\GroomingMaster;
use App\Models\AppointmentService;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function step1()
    {
        $user = auth()->user();
        $pets = Pet::where('User_ID', $user->ID_User)->get();
        return view('booking', [
            'step' => 1,
            'pets' => $pets
        ]);
    }

    public function postSize(Request $request)
    {
        if ($request->has('pet_id')) {
            session(['booking.pet_id' => $request->input('pet_id')]);
            session()->forget('booking.size');
        } else {
            $request->validate(['breed_category' => 'required']);
            session(['booking.size' => $request->input('breed_category')]);
            session()->forget('booking.pet_id');
        }
        return redirect()->route('booking.service');
    }

    public function step2()
    {
        $pet_id = session('booking.pet_id');
        if ($pet_id) {
            $pet = Pet::find($pet_id);
            $size = $pet ? $pet->breed_category : null;
        } else {
            $size = session('booking.size');
        }
        $services = Service::where('Breed_category', $size)->get();
        return view('booking', [
            'step' => 2,
            'services' => $services
        ]);
    }

    public function postService(Request $request)
    {
        $request->validate(['services' => 'required|array|min:1']);
        session(['booking.services' => $request->input('services')]);
        return redirect()->route('booking.time');
    }

    public function step3(Request $request)
    {
        $date = session('booking.date', date('Y-m-d'));
        $selectedMaster = session('booking.master', null);
        $masters = GroomingMaster::all();
        $busyTimes = [];

        if ($date && $selectedMaster) {
            $busyTimes = Appointment::where('Date', $date)
                ->where('ID_Master', $selectedMaster)
                ->pluck('Time')
                ->toArray();
        }
        return view('booking', [
            'step' => 3,
            'busyTimes' => $busyTimes,
            'masters' => $masters,
            'selectedMaster' => $selectedMaster
        ]);
    }

    public function postTime(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'master' => 'required|integer|exists:grooming_masters,ID_Master',
            'agree' => 'accepted'
        ]);
        session([
            'booking.date' => $request->appointment_date,
            'booking.time' => $request->appointment_time,
            'booking.master' => $request->master
        ]);
        return redirect()->route('booking.confirm');
    }

    public function confirm()
    {
        return view('booking', ['step' => 4]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $date = session('booking.date');
        $time = session('booking.time');
        $master_id = session('booking.master');
        $servicesArray = session('booking.services', []); // ← ВАЖНО: если нет сессии, пустой массив
        $pet_id = session('booking.pet_id', null);

        // Проверка, что услуги выбраны
        if (empty($servicesArray)) {
            return back()->with('error', 'Выберите хотя бы одну услугу');
        }

        // Проверка, что время не занято
        $exists = Appointment::where('ID_Master', $master_id)
            ->where('Date', $date)
            ->where('Time', $time)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Мастер уже занят на это время');
        }

        // Создание записи
        $appointment = new Appointment();
        $appointment->User_ID = $user->ID_User;
        $appointment->ID_Master = $master_id;
        $appointment->Date = $date;
        $appointment->Time = $time;
        $appointment->ID_status = 1;
        $appointment->Pets_ID = $pet_id;
        $appointment->save();

        // Сохранение ВСЕХ услуг в appointment_services
        foreach ((array) $servicesArray as $service_id) {
            AppointmentService::create([
                'ID_Appointments' => $appointment->ID_Appointments,
                'ID_Services' => (int) $service_id
            ]);
        }

        // Очистка сессии
        session()->forget([
            'booking.pet_id',
            'booking.size',
            'booking.date',
            'booking.time',
            'booking.master',
            'booking.services'
        ]);

        return redirect()->route('booking.confirm')->with('success', 'Запись успешно сохранена');
    }

    public function getBusyTimesAjax(Request $request)
    {
        $date = $request->input('date');
        $master = $request->input('master');
        $busyTimes = [];

        if ($date && $master) {
            $busyTimes = Appointment::where('Date', $date)
                ->where('ID_Master', $master)
                ->pluck('Time')
                ->map(function($t) {
                    return substr($t, 0, 5);
                })->toArray();
        }

        return response()->json(['busyTimes' => $busyTimes]);
    }
}
