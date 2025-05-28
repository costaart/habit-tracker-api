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
        $token = request()->string('token');
        // $token = request()->bearerToken();

        abort_unless($token == '2097', 403);

        
        request()->validate([
            'with' => ['string', 'nullable', 'in:user']
        ]);
        

        // Essa forma não é performática, pois ela busca todos os registros 1 vez, depois no Resource ele faz outra query buscando os relacionamentos
        // return HabitResource::collection(
        //    Habit::all()
        // );

        // Dessa forma, se eu passar já os relacionamentos ele poupa queries duplicadas
        // return HabitResource::collection(
        //     Habit::query()
        //     ->with(['user', 'logs'])
        //     ->get()
        // );

        // Trazer os resultados caso o tenha query na api ?with
        return HabitResource::collection(
            Habit::query()
            ->when(
                str(request()->string('with', ''))->contains('user'),
                fn($query) => $query->with('user')
            )
            ->when(
                str(request()->string('with', ''))->contains('logs'),
                fn($query) => $query->with('logs')
            )
            ->paginate()
        );
    }


    public function store(StoreHabitRequest $request)
    {
        $habit = Habit::create(array_merge($request->validated(), ['user_id' => 3]));
        return HabitResource::make($habit);
    }

    public function show(Habit $habit)
    {
        return HabitResource::make($habit);
    }

    public function update(UpdateHabitRequest $request, Habit $habit)
    {
        $habit->update($request->validated());
        return HabitResource::make($habit);
    }

    public function destroy(Habit $habit)
    {
        $habit->delete();

        return response()->noContent();
    }

}