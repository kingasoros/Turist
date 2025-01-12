<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|integer|exists:tours,tour_id',
        ]);

        $userId = Auth::id();
        $tourId = $request->tour_id;

        $existingFavorite = DB::table('turist_favorites')
                            ->where('id', $userId)
                            ->where('tour_id', $tourId)
                            ->exists();

        if (!$existingFavorite) {
            DB::table('turist_favorites')->insert([
                'id' => $userId,
                'tour_id' => $tourId,
            ]);
        }

        return redirect()->back()->with('favorite_added', true);
    }

    public function delete(Request $request)
    {
        $userId = $request->input('user_id');
        $tourId = $request->input('tour_id');

        $deleted = DB::table('turist_favorites')
                    ->where('id', $userId)
                    ->where('tour_id', $tourId)
                    ->delete();

        if ($deleted) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => true]);
    }

}
