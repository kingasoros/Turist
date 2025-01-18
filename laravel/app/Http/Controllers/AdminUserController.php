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

        $user->is_active = true;
        $user->approval_token = null; 
        $user->save();

        Mail::to($user->email)->send(new UserApprovedMail($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'A fiókod sikeresen aktiválva lett!');
    }
}
