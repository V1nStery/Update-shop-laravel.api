<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */

    protected function redirectTo(Request $request): ?string
    {
        //  Убираем редирект совсем,  так как он не нужен для SPA
        return null; 
    }

protected function unauthenticated($request, array $guards)
    {
        // Всегда возвращаем JSON с 401, независимо от типа запроса
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}



