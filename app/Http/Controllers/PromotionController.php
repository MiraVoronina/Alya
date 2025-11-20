<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Service;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('service')->get();
        return view('promotions', compact('promotions'));
    }

    public function show($id)
    {
        $promotion = Promotion::with('service')->findOrFail($id);
        return view('promotion_show', compact('promotion'));
    }

    public function create()
    {
        $services = Service::all();
        return view('promotion_create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required|string|max:255',
            'ID_Services' => 'required|integer|exists:Services,ID_Services',
            'Description' => 'nullable|string',
            'Image_url' => 'nullable|string'
        ]);

        Promotion::create($request->all());
        return redirect()->route('promotions')->with('success', 'Акция добавлена!');
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        $services = Service::all();
        return view('promotion_edit', compact('promotion', 'services'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'Title' => 'required|string|max:255',
            'ID_Services' => 'required|integer|exists:Services,ID_Services',
            'Description' => 'nullable|string',
            'Image_url' => 'nullable|string'
        ]);

        $promotion->update($request->all());
        return redirect()->route('promotions')->with('success', 'Акция обновлена!');
    }

    public function destroy($id)
    {
        Promotion::findOrFail($id)->delete();
        return redirect()->route('promotions')->with('success', 'Акция удалена!');
    }
}
