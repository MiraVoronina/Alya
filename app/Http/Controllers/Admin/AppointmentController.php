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

        $query = Appointment::with([
            'user',
            'pet',
            'master',
            'appointmentServices.service'
        ]);

        if ($filter_master) {
            $query->where('ID_Master', $filter_master);
        }
        if ($filter_date) {
            $query->where('Date', $filter_date);
        }

        $appointments = $query->orderBy('Date', $sort)->paginate(15);
        $masters = GroomingMaster::all();

        return view('admin.appointments.index', compact('appointments', 'sort', 'masters'));
    }

    public function setStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Возьми значение из формы. Если ничего не пришло — не меняй!
        $newStatus = $request->input('ID_status');
        if (!is_null($newStatus) && $newStatus !== '') {
            $appointment->ID_status = $newStatus;
            $appointment->save();
            return redirect()->back()->with('success', 'Статус заявки обновлен!');
        } else {
            // Нет значения — не обновляй
            return redirect()->back()->with('error', 'Ошибка: статус не выбран!');
        }
    }
}
