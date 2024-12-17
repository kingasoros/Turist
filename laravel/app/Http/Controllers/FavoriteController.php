<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function addToFavorites(Request $request)
    {
        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Not authenticated'], 401);
        }

        // A kérés validálása
        $request->validate([
            'attractions_id' => 'required|integer|exists:attractions,attractions_id',
        ]);

        // Ellenőrizzük, hogy már nem szerepel-e a kedvencek között
        $existingFavorite = DB::table('turist_favorites')
            ->where('id', $userId)
            ->where('attractions_id', $request->input('attractions_id'))
            ->exists();

        if ($existingFavorite) {
            return response()->json(['message' => 'Already in favorites!'], 409);
        }

        // Adatbevitel a `turist_favorites` táblába
        DB::table('turist_favorites')->insert([
            'id' => $userId,
            'attractions_id' => $request->input('attractions_id'),
        ]);

        return response()->json(['message' => 'Added to favorites successfully!']);
    }
}
