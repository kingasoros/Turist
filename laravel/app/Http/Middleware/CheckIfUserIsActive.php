<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Ha be van jelentkezve és a felhasználó inaktív, kijelentkeztetjük
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout();
            return redirect('/login')->withErrors([  // Itt a login oldalra irányítjuk
                'email' => 'A fiókod még nem lett aktiválva. Kérjük, erősítsd meg az email-edet az aktiváláshoz.',
            ]);
        }

        // Ha a felhasználó aktív, akkor továbbengedjük a kérést
        return $next($request);
    }

    // public function handle(Request $request, Closure $next)
    // {
    //     // Ellenőrizzük, hogy a felhasználó már regisztrálta-e az e-mail címét és az aktív státuszt.
    //     $user = User::where('email', $request->input('email'))->first();

    //     if ($user && !$user->is_active) {
    //         return redirect('/register')->withErrors([
    //             'email' => 'Ez az e-mail cím már regisztrálva van, de a fiókod még nem aktivált. Kérlek, erősítsd meg az email-edet.',
    //         ]);
    //     }

    //     return $next($request);
    // }

}
