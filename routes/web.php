<?php

use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [config('app.name')];
});

Route::prefix('/api')->name('api.')->group(function (){

    // Route::get('/habits', [HabitController::class, 'index'])->name('habits.index');
    // Route::get('/habits/{habit:uuid}', [HabitController::class, 'show'])->name('habits.show');
    // Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');
    // Route::put('/habits/{habit:uuid}', [HabitController::class, 'update'])->name('habits.update');
    // Route::delete('/habits/{habit:uuid}', [HabitController::class, 'destroy'])->name('habits.destroy');

    // É uma forma simples de declarar todas essas rotas acima, usando a convenção do Route Model Binding
    Route::apiResource('habits', HabitController::class)->scoped(['habit' => 'uuid']);

    // Route::get('/habits/{habit:uuid}/logs', [HabitLogController::class, 'index'])->name('habits.logs.index');
    Route::apiResource('habits.logs', HabitLogController::class)
    ->only('index', 'store', 'destroy')
    ->scoped(['habit' => 'uuid', 'log' => 'uuid']);
});