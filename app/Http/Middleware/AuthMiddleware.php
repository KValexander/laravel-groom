<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
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
        // Если пользователь авторизован
        if(Auth::check()) {
            // Идёт дальше
            return $next($request);
        // Если нет
        } else {
            // Перенправление на главную страницу с сообщение об ошибке
            return redirect()->route("main_page")->withErrors("Вы не авторизованы", "message");
        }
    }
}
