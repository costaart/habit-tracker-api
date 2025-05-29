<?php

use Illuminate\Http\Request;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitLogController;
use Illuminate\Support\Facades\Route;

// Esse arquivo é para apis autenticadas
// Route::get('/habits', [HabitController::class, 'index'])->name('habits.index');
// Route::get('/habits/{habit:uuid}', [HabitController::class, 'show'])->name('habits.show');
// Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');
// Route::put('/habits/{habit:uuid}', [HabitController::class, 'update'])->name('habits.update');
// Route::delete('/habits/{habit:uuid}', [HabitController::class, 'destroy'])->name('habits.destroy');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api.')->middleware('auth:sanctum')->group(function(){
    // É uma forma simples de declarar todas essas rotas acima, usando a convenção do Route Model Binding
    Route::apiResource('habits', HabitController::class)
    ->scoped(['habit' => 'uuid']);

    Route::apiResource('habits.logs', HabitLogController::class)
    ->only('index', 'store', 'destroy')
    ->scoped(['habit' => 'uuid', 'log' => 'uuid']);
});

