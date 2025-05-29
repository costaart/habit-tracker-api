<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitRequest;
use App\Http\Requests\UpdateHabitRequest;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware("can:own,habit", except: ['index', 'store']),
        ];
    }

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
            ->where('user_id', Auth::id())
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
        $habit = Auth::user()->habits()->create(($request->validated()));

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