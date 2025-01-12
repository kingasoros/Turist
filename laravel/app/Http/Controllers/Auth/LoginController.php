<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an incoming login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Bejelentkezés próbálkozás
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ellenőrizni, hogy a felhasználó aktív-e
            if (Auth::user()->is_active) {
                return redirect()->intended(RouteServiceProvider::HOME);
            }

            // Ha a felhasználó nem aktív, kijelentkeztetjük
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['A fiókod még nem lett aktiválva. Kérjük, ellenőrizd az emailt a fiók aktiválásához.'],
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }
}
