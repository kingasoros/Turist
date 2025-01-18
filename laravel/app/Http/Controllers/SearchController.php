<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchRecord;

class SearchController extends Controller
{
    public function insertNewSearchRecord(Request $request)
{
    // A kérés adatait kiírjuk a logba
    \Log::info('Request data: ' . json_encode($request->all())); 

    try {
        $request->validate([
            'city' => 'required|string',
            'type' => 'required|string',
        ]);

        // Az adatokat elmentjük az adatbázisba (timestamp nem szükséges)
        SearchRecord::create([
            'city' => $request->city,
            'type' => $request->type,
        ]);

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        // Ha hiba lép fel, logoljuk és válaszolunk egy hibával
        \Log::error('Error while saving search record: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}

}
