<?php

namespace App\Http\Middleware;

use Closure;
use App\Constants\UserRoles;
use Illuminate\Support\Facades\Auth;


class AdminCheck
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
        if (Auth::check() && Auth::user()->role===UserRoles::ADMINISTRATOR)
            return $next($request);

        return redirect()->route('client.landing');
    }
}
