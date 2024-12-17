<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_name' => 'required|string|max:255',
            'tour_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:private,public',
            'attractions' => 'nullable|array',
            'attractions.*' => 'integer|exists:attractions,attractions_id',
        ]);

        $tourId = DB::table('tours')->insertGetId([
            'tour_name' => $validated['tour_name'],
            'tour_description' => $validated['tour_description'],
            'price' => $validated['price'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
            'created_at' => now(),
        ]);
        if (!empty($validated['attractions'])) {
            foreach ($validated['attractions'] as $index => $attractionId) {
                DB::table('tour_attractions')->insert([
                    'tour_id' => $tourId,
                    'attractions_id' => $attractionId,
                    'attraction_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('tours_make')->with('success', 'Túra sikeresen létrehozva!');
    }
}
