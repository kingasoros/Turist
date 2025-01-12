<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserApprovedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function activateUser($id, $token)
    {   
        $user = User::where('id', $id)->where('approval_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Érvénytelen link vagy már aktivált felhasználó.'], 404);
        }

        // A felhasználó aktiválása
        $user->is_active = true;
        $user->approval_token = null; // A token már nem szükséges
        $user->save();

        // Email küldése a felhasználónak a sikeres aktiválásról
        Mail::to($user->email)->send(new UserApprovedMail($user));

        // Bejelentkezés után a felhasználó automatikusan beléphet (ha ezt szeretnéd)
        Auth::login($user);

        // Visszairányítás a dashboard-ra és sikerüzenet
        return redirect()->route('dashboard')->with('success', 'A fiókod sikeresen aktiválva lett!');
    }
}
