<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Str;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $existingUser = User::where('email', $request->email)->first();

    if ($existingUser && !$existingUser->is_active) {
        return redirect()->route('register')
                         ->withErrors(['email' => 'Ez az e-mail cím már regisztrálva van, de a fiókod még nem aktivált. Kérjük, erősítsd meg az email-edet.']);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    $user->activation_token = Str::random(64);
    $user->save();

    Mail::to($user->email)->send(new WelcomeMail($user));

    Auth::login($user);

    // Ellenőrizzük az aktív státuszt bejelentkezés után
    if (!$user->is_active) {
        Auth::logout();
        return redirect('/login')->withErrors([
            'email' => 'A fiókod még nem lett aktiválva. Kérjük, erősítsd meg az email-edet az aktiváláshoz.',
        ]);
    }

    return redirect(RouteServiceProvider::HOME);
}

}
