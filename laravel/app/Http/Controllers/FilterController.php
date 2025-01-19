<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FilterController extends Controller
{
    public function saveFilterSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filters' => 'array|required',
            'filters.*.name' => 'required|string|max:255',
            'filters.*.value' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            $filters = $request->input('filters', []);

            foreach ($filters as $filter) {
                if (!empty($filter['value'])) {
                    DB::table('filter_search_statistics')->insert([
                        'filter_name' => $filter['name'],
                        'filter_value' => $filter['value'],
                    ]);
                }
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
