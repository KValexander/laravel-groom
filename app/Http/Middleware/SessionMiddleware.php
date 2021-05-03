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
        // Если пользователь авторизован
        if(Auth::check()) {
            // Получение данных авторизованного пользователя
            $user = Auth::user();
            // Присваивание роли пользоваля
            $role = $user->role;
            // Присваивание id пользователя
            $user_id = $user->id;
        // Если нет
        } else {
            // Присваиваем роль гостя
            $role = "guest";
            // Присваиваем нулевой id пользователя
            $user_id = 0;
        }

        // Отправка всем представлениям входящим в группу переменных $role и $user_id
        view()->share(["role" => $role, "user_id" => $user_id]);

        // Идём дальше
        return $next($request);
    }
}
