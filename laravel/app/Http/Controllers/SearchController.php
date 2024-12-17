<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $results = Order::search($query)->get();
        return response()->json($results);
    }
}
