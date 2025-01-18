<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FilterController extends Controller
{
    public function saveFilterSearch(Request $request)
    {
        // A kérés validálása, hogy a filters egy tömb és megfelelő formátumban legyen
        $validator = Validator::make($request->all(), [
            'filters' => 'array|required',
            'filters.*.name' => 'required|string|max:255',
            'filters.*.value' => 'nullable|string|max:255',
        ]);

        // Ha a validálás nem sikerült, hibát küldünk válaszként
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            // A filter adatokat beillesztjük az adatbázisba
            $filters = $request->input('filters', []);

            foreach ($filters as $filter) {
                if (!empty($filter['value'])) {
                    // Adatok beillesztése a 'filter_search_statistics' táblába
                    DB::table('filter_search_statistics')->insert([
                        'filter_name' => $filter['name'],
                        'filter_value' => $filter['value'],
                    ]);
                }
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Hibakezelés
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
