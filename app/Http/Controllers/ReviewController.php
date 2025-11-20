<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'service'])->get();

        $services = [];
        if(auth()->check()) {
            $userId = auth()->user()->ID_User;
            $services = \DB::table('appointments')
                ->join('services', 'appointments.Services_ID', '=', 'services.ID_Services')
                ->join('status', 'appointments.ID_status', '=', 'status.ID_Status')
                ->where('appointments.User_ID', $userId)
                ->whereIn('status.Order_Status_Name', ['завершен', 'отменен'])
                ->select('services.ID_Services', 'services.Title')
                ->distinct()
                ->get();
        }

        return view('works', compact('reviews', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Services_ID' => 'required|integer',
            'Rating' => 'required|integer|min:1|max:5',
            'Content' => 'required|string'
        ]);

        Review::create([
            'User_ID' => auth()->user()->ID_User,
            'Services_ID' => $request->Services_ID,
            'Rating' => $request->Rating,
            'Content' => $request->Content
        ]);
        return redirect()->route('works')->with('success', 'Отзыв добавлен!');
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return redirect()->route('works')->with('success', 'Отзыв удалён!');
    }
}
