<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{

    public function index()
    {
        return HabitResource::collection(
           Habit::all()
        );
    }


    public function store(StoreHabitRequest $request)
    {
        $data = $request->only('name', 'uuid');
        $habit = Habit::create(array_merge($data, ['user_id' => 3]));
        return HabitResource::make($habit);
    }

    public function show(Habit $habit)
    {
        return HabitResource::make($habit);
    }

    public function update(UpdateHabitRequest $request, Habit $habit)
    {
        $data = $request->validated();
        $habit->update($data);
        return HabitResource::make($habit);
    }

    public function destroy(Habit $habit)
    {
        $habit->delete();

        return response()->noContent();
    }

}