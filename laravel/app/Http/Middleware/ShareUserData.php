<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ShareUserData
{
    public function handle($request, Closure $next)
    {
        View::share('user_role', Session::get('user_role'));
        View::share('user_name', Session::get('user_name', 'Vendég'));

        return $next($request);
    }
}

