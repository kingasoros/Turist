<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function subscribeToCities(Request $request)
    {
        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        $user = auth()->user();

        // Validáljuk a bejövő adatokat (ellenőrizzük, hogy a városok ID-jai léteznek-e)
        $request->validate([
            'selected_cities' => 'required|array',
            'selected_cities.*' => 'exists:cities,city_id', // Ellenőrizzük, hogy a város létezik-e a 'cities' táblában
        ]);

        // Töröljük a korábbi előfizetéseket a felhasználónál
        DB::table('subscribe')->where('user_id', $user->id)->delete();

        // Hozzáadjuk az új előfizetéseket
        foreach ($request->selected_cities as $cityId) {
            DB::table('subscribe')->insert([
                'user_id' => $user->id,
                'city_id' => $cityId,
            ]);
        }

        // Visszairányítjuk a felhasználót, és sikeres üzenetet küldünk
        return redirect()->back()->with('success', 'You have successfully subscribed to the selected cities.');
    }
}
