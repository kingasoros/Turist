<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;

class AttractionController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query', '');

        // Keresés az `attractions` táblában
        $results = Attraction::where('name', 'LIKE', '%' . $query . '%')->get();

        // Eredmények JSON formátumban való visszaküldése
        return response()->json($results);
    }
}
