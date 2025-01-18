<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; 

class AdminController extends Controller
{
    public function showDashboard()
    {
        $user = Auth::user();
        $user_role = $user->role;
        $user_name = $user->name;

        // Laravel session beállítása
        Session::put('user_role', $user_role);
        Session::put('user_name', $user_name);

        return view('admin.dashboard');
    }
}

