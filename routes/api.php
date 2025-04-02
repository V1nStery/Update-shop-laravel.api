<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CallbackController;
use App\Http\Controllers\VisitController;


Route::post('/login', [AuthController::class, 'login']);

Route::get('/products/{product}', [ProductController::class, 'show']); // Для одного товара

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::put('/orders/{order}/processed', [OrderController::class, 'updateProcessedStatus']);

Route::post('/callbacks', [CallbackController::class, 'store']);
Route::get('/callbacks', [CallbackController::class, 'index']);
Route::put('/callbacks/{callback}/processed', [CallbackController::class, 'updateProcessedStatus']);


// Маршрут для записи посещения
Route::post('/track-visit', [VisitController::class, 'trackVisit']);

// Маршрут для получения данных о посещаемости
Route::get('/site-traffic', [VisitController::class, 'getLast7DaysVisits']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::post('/products/{product}/image', [ProductController::class, 'updateImage']); // Убедитесь, что эта строка есть
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $user->load('role'); // Загружаем связанную роль

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role->name, // Возвращаем имя роли
    ]);
});


Route::middleware('auth:sanctum')->put('/users/{user}/role', function (Request $request, User $user) {
    // Проверь, имеет ли текущий пользователь право менять роли
    if (!auth()->user()->isAdmin()) {
        return response()->json(['message' => 'Unauthorized'], 403);


    }

    $request->validate(['role' => 'required|in:admin,user']); // Валидация

    $user->role = $request->input('role');
    $user->save();

    return response()->json(['message' => 'Role updated successfully']);
});





