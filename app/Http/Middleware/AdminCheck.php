<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use http\Env\Request;
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
        if (Auth::check() && Auth::user()->role=='Administrador')
            return $next($request);

        return redirect('/home');
    }
}
