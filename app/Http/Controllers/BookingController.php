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
        $request->validate([
            'breed_category' => 'required|string'
        ]);

        if ($request->has('pet_id') && $request->pet_id) {
            session(['booking.pet_id' => $request->input('pet_id')]);
            session()->forget('booking.size');
        } else {
            session(['booking.size' => $request->input('breed_category')]);
            session()->forget('booking.pet_id');
        }
        return redirect()->route('booking.service');
    }

    public function step2()
    {
        $pet_id = session('booking.pet_id');
        $breed_category = null;

        if ($pet_id) {
            $pet = Pet::find($pet_id);
            $breed_category = $pet ? $pet->breed_category : null;
        } else {
            $breed_category = session('booking.size');
        }

        if (!$breed_category) {
            return redirect()->route('booking')->with('error', 'Выберите размер собаки');
        }

        $services = Service::where('Breed_category', $breed_category)->get();

        return view('booking', [
            'step' => 2,
            'services' => $services,
            'breed_category' => $breed_category
        ]);
    }

    public function postService(Request $request)
    {
        $request->validate([
            'services' => 'required|array|min:1',
            'services.*' => 'integer|exists:services,ID_Services'
        ]);

        session(['booking.services' => $request->input('services')]);
        return redirect()->route('booking.time');
    }

    public function step3()
    {
        $services = session('booking.services');
        if (!$services) {
            return redirect()->route('booking.service')->with('error', 'Выберите услуги');
        }

        $masters = GroomingMaster::all();
        $selectedMaster = session('booking.master', null);

        return view('booking', [
            'step' => 3,
            'masters' => $masters,
            'selectedMaster' => $selectedMaster
        ]);
    }

    public function postTime(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'master' => 'required|integer|exists:grooming_masters,ID_Master',
            'agree' => 'accepted'
        ]);

        // Проверка, что время не занято
        $exists = Appointment::where('ID_Master', $request->master)
            ->where('Date', $request->appointment_date)
            ->where('Time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Мастер уже занят на это время. Выберите другое время.');
        }

        session([
            'booking.date' => $request->appointment_date,
            'booking.time' => $request->appointment_time,
            'booking.master' => $request->master
        ]);

        return redirect()->route('booking.confirm');
    }

    public function confirm()
    {
        $services = session('booking.services');
        $date = session('booking.date');
        $time = session('booking.time');
        $master_id = session('booking.master');

        if (!$services || !$date || !$time || !$master_id) {
            return redirect()->route('booking')->with('error', 'Заполните все поля');
        }

        return view('booking', ['step' => 4]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $date = session('booking.date');
        $time = session('booking.time');
        $master_id = session('booking.master');
        $servicesArray = session('booking.services', []);
        $pet_id = session('booking.pet_id', null);

        // Проверка всех обязательных полей
        if (!$date || !$time || !$master_id || empty($servicesArray)) {
            return redirect()->route('booking')->with('error', 'Заполните все необходимые поля');
        }

        // Проверка ещё раз, что время не занято
        $exists = Appointment::where('ID_Master', $master_id)
            ->where('Date', $date)
            ->where('Time', $time)
            ->exists();

        if ($exists) {
            return redirect()->route('booking.time')->with('error', 'Мастер уже занят на это время');
        }

        // Создание записи
        $appointment = new Appointment();
        $appointment->User_ID = $user->ID_User;
        $appointment->ID_Master = $master_id;
        $appointment->Date = $date;
        $appointment->Time = $time;
        $appointment->ID_status = 1; // "Новая заявка"
        $appointment->Pets_id = $pet_id;
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

        return redirect()->route('home')->with('success', 'Запись успешно создана! Ожидайте подтверждения.');
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
                    return substr($t, 0, 5); // Форматируем как HH:MM
                })->toArray();
        }

        return response()->json(['busyTimes' => $busyTimes]);
    }
}
