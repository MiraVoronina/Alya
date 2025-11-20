<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::all();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $promotion = new Promotion();
        $promotion->Title = $request->input('Title');
        $promotion->Description = $request->input('Description');

        // Загрузка файла
        if ($request->hasFile('Image_file')) {
            $file = $request->file('Image_file');
            $path = $file->store('promotions', 'public');
            $promotion->Image_url = '/storage/' . $path;
        }

        $promotion->Created_at = now();
        $promotion->save();

        return redirect()->route('admin.promotions.index');
    }

    public function show($id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.show', compact('promotion'));
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->Title = $request->input('Title');
        $promotion->Description = $request->input('Description');

        // Загрузка нового файла (если выбран)
        if ($request->hasFile('Image_file')) {
            $file = $request->file('Image_file');
            $path = $file->store('promotions', 'public');
            $promotion->Image_url = '/storage/' . $path;
        }

        $promotion->save();

        return redirect()->route('admin.promotions.index');
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();
        return redirect()->route('admin.promotions.index');
    }
}
