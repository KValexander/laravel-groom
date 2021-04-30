<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionMiddleware
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
        if(Auth::check()) {
            $user = Auth::user();
            $role = $user->role;
            $user_id = $user->id;
        } else {
            $role = "guest";
            $user_id = 0;
        }

        view()->share(["role" => $role, "user_id" => $user_id]);

        return $next($request);
    }
}
