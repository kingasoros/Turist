<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tour;
use App\Models\Attraction;
use Illuminate\Support\Facades\Mail;
use App\Mail\TourCreated;


class TourController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'tour_name' => 'required|string|max:255',
        'tour_description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|in:private,public',
        'attractions' => 'nullable|array',
        'attractions.*' => 'integer|exists:attractions,attractions_id',
    ]);

    // Túra létrehozása
    $tourId = DB::table('tours')->insertGetId([
        'tour_name' => $validated['tour_name'],
        'tour_description' => $validated['tour_description'],
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
        'status' => $validated['status'],
        'favorites_count' => 0,
        'created_at' => now(),
    ]);

    // Látványosságok hozzáadása a túrához
    if (!empty($validated['attractions'])) {
        foreach ($validated['attractions'] as $index => $attractionId) {
            DB::table('tour_attractions')->insert([
                'tour_id' => $tourId,
                'attractions_id' => $attractionId,
                'attraction_order' => $index + 1,
            ]);
        }
    }

    // A látványosságok városainak lekérdezése
    $cityNames = DB::table('attractions')
                   ->whereIn('attractions_id', $validated['attractions'])
                   ->pluck('city_name')
                   ->unique();

    // Felhasználók keresése a városok alapján
    $subscribedUserIds = DB::table('subscribe')
                            ->whereIn('city_id', function($query) use ($cityNames) {
                                $query->select('city_id')
                                      ->from('cities')
                                      ->whereIn('city_name', $cityNames);
                            })
                            ->pluck('user_id');

    // E-mailek lekérdezése
    $emails = DB::table('users')
                ->whereIn('id', $subscribedUserIds)
                ->pluck('email')
                ->toArray();

    // E-mail küldése
    if (count($emails) > 0) {
        Mail::to($emails)->send(new TourCreated($validated));
    }

    return redirect()->route('tours_make')->with('success', 'Túra sikeresen létrehozva!');
}

    
    public function destroy(Tour $tour)
    {
        $tour->attractions()->detach();
        
        $tour->delete();

        return redirect()->route('tours_make')->with('success', 'Túra sikeresen törölve!');
        // return redirect()->route('tours.index')->with('success', 'Túra sikeresen törölve!');
    }


    public function index()
    {
        $tours = Tour::all(); 
        return view('static-pages.front.php.tours', compact('tours'));

    }

}
