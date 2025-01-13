<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckIfUserCanRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ellenőrizzük, hogy a felhasználó már regisztrálta-e az e-mail címét és az aktív státuszt.
        $user = User::where('email', $request->input('email'))->first();

        if ($user && !$user->is_active) {
            return redirect('/register')->withErrors([
                'email' => 'Ez az e-mail cím már regisztrálva van, de a fiókod még nem aktivált. Kérlek, erősítsd meg az email-edet.',
            ]);
        }

        return $next($request);
    }
}
