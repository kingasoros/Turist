<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\SearchRecord;

class SearchController extends Controller
{
    public function insertNewSearchRecord(Request $request)
{
    // A kérés adatait kiírjuk a logba
    \Log::info('Request data: ' . json_encode($request->all())); 

    // Debugging output
    dd($request->all());  // Megállítja a kérést és kiírja a JSON adatokat

    $request->validate([
        'city' => 'required|string',
        'type' => 'required|string',
        'interest' => 'required|string',
        'timestamp' => 'required|date',
    ]);

    // Az adatokat elmentjük az adatbázisba
    FilterSearchStatistic::create([
        'city' => $request->city,
        'type' => $request->type,
        'interest' => $request->interest,
        'timestamp' => $request->timestamp,
    ]);

    return response()->json(['success' => true]);
}

}
