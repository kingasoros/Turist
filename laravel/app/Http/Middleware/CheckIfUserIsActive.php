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
            // return redirect('/login')->withErrors([  // Itt a login oldalra irányítjuk
            //     'email' => 'A fiókod még nem lett aktiválva. Kérjük, erősítsd meg az email-edet az aktiváláshoz.',
            // ]);
        }

        // Ha a felhasználó aktív, akkor továbbengedjük a kérést
        return $next($request);
    }



}
