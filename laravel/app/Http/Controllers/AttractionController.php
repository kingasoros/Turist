<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;
use App\Models\FilterSearchStatistic;
use Illuminate\Support\Facades\Log;


class AttractionController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query', '');

        $results = Attraction::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json($results);
    }

    public function saveFilterStatistics(Request $request)
    {
        Log::info('Incoming request data:', $request->all());

        $filters = $request->all();

        foreach ($filters as $filterName => $filterValue) {
            if (!empty($filterValue)) {
                $existingRecord = FilterSearchStatistic::where('filter_name', $filterName)
                                                        ->where('filter_value', $filterValue)
                                                        ->first();

                if ($existingRecord) {
                    $existingRecord->count += 1;
                    $existingRecord->save();
                } else {
                    FilterSearchStatistic::create([
                        'filter_name' => $filterName,
                        'filter_value' => $filterValue,
                        'count' => 1,
                    ]);
                }
            }
        }

        return response()->json(['success' => true]);
    }
}

