<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [config('app.name')];
});


Route::middleware('guest')->group(function(){
    Route::post('/api/register', [AuthController::class, 'register']);
});
