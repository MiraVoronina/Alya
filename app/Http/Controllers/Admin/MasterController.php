<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroomingMaster;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        $masters = GroomingMaster::all();
        return view('admin.masters.index', compact('masters'));
    }

    public function create()
    {
        return view('admin.masters.create');
    }

    public function store(Request $request)
    {
        // 1. Создаем пользователя-админа
        $user = new \App\Models\User();
        $user->Login = $request->input('login');
        $user->Password = bcrypt($request->input('password')); // обязательно хешируй!
        $user->ID_User_Role = 2; // тип "мастер" или "админ", подставь, если роли мастеров "2"
        $user->Avatar_url = null;
        $user->save();

        // 2. Создаем запись мастера с привязкой к user
        $master = new GroomingMaster();
        $master->ID_User = $user->ID_User;
        $master->name = $request->input('name');
        $master->Created_at = now();
        $master->save();

        return redirect()->route('admin.masters.index');
    }


    public function show($id)
    {
        $master = GroomingMaster::findOrFail($id);
        return view('admin.masters.show', compact('master'));
    }

    public function edit($id)
    {
        $master = GroomingMaster::findOrFail($id);
        return view('admin.masters.edit', compact('master'));
    }

    public function update(Request $request, $id)
    {
        $master = GroomingMaster::findOrFail($id);
        $master->name = $request->input('name');
        $master->save();

        return redirect()->route('admin.masters.index');
    }

    public function destroy($id)
    {
        $master = GroomingMaster::findOrFail($id);
        $master->delete();
        return redirect()->route('admin.masters.index');
    }
}
