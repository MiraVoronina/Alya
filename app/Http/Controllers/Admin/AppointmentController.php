<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\GroomingMaster;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'desc');
        $filter_master = $request->input('filter_master');
        $filter_date = $request->input('filter_date');

        // Базовый запрос с загрузкой отношений
        $query = Appointment::with([
            'user',
            'pet',
            'master',
            'appointmentServices.service'
        ]);

        // Фильтр по мастеру
        if ($filter_master) {
            $query->where('ID_Master', $filter_master);
        }

        // Фильтр по дате
        if ($filter_date) {
            $query->where('Date', $filter_date);
        }

        // Сортировка и пагинация
        $appointments = $query->orderBy('Date', $sort)->paginate(15);

        // Получи всех мастеров для выпадающего списка
        $masters = GroomingMaster::all();

        return view('admin.appointments.index', compact('appointments', 'sort', 'masters'));
    }
}
