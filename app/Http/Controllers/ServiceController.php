<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->route()->getActionMethod() === 'showServicesPage') {
                return $next($request);
            }
            if (auth()->check() && auth()->user()->isAdmin()) {
                return $next($request);
            }
            abort(403, 'Access denied');
        });
    }

    public function showServicesPage()
    {
        $bigServices = Service::where('Breed_category', 'Большие породы')->get();
        $mediumServices = Service::where('Breed_category', 'Средние породы')->get();
        $smallServices = Service::where('Breed_category', 'Мелкие породы')->get();
        return view('services', compact('bigServices', 'mediumServices', 'smallServices'));
    }

    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Title' => 'required|string|max:255',
            'Price' => 'required|numeric|min:0',
            'Breed_category' => 'required|string|max:100'
        ]);
        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Услуга добавлена!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'Title' => 'required|string|max:255',
            'Price' => 'required|numeric|min:0',
            'Breed_category' => 'required|string|max:100'
        ]);
        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Услуга обновлена!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Услуга удалена!');
    }
}
