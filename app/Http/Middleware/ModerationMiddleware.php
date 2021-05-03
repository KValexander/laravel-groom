<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModerationMiddleware
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
        // Получение данных авторизованного пользователя
        $user = Auth::user();
        
        // Если пользователь является администратором
        if($user->role == "admin") {
            // Идёт дальше
            return $next($request);
        // Если нет
        } else {
            // Перенправление на главную страницу с сообщение об ошибке
            return redirect()->route("main_page")->withErrors("Ошибка прав доступа", "message");
        }
    }
}
