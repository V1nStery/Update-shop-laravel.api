<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Не забудьте импортировать модель User
use Illuminate\Support\Facades\Hash; //  Для  bcrypt


class AuthController extends Controller
{
    public function login(Request $request)
    {        
        $credentials = $request->only('email', 'password');


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) { // Используй Hash::check для сравнения паролей
            return response()->json(['message' => 'Invalid credentials'], 401);
        }


        $token = $user->createToken('my-app-token')->plainTextToken; // <--  Создаём  токен

        return response()->json([
            'message' => 'Login successful',
            'token' => $token, // <--  Возвращаем  токен
            'user' => $user,  // Можно и юзера вернуть, если нужно
        ], 200);
    }
}