<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitLogRequest;
use App\Http\Resources\HabitLogResource;
use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;

class HabitLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Habit $habit)
    {
        return HabitLogResource::collection(
            $habit->logs()
            ->paginate()
        );
    }

    public function store(StoreHabitLogRequest $request, Habit $habit)
    {
        //Ele acessa o habit, vai no relacionamento de logs (HabitLog) e verifica, se existe um log com o mesmo uuid
        //e o mesmo completed_at, se sim, atualiza, se não, ele cria. Não deixa duplicar
        $log = $habit->logs()->updateOrCreate([
            'completed_at' => $request->date('completed_at'),
        ]);
        
        // O resource é para exibir e o make é porque é somente um rgistro
        return HabitLogResource::make($log);
    }

    public function destroy(Habit $habit, HabitLog $log)
    {
        $log->delete();

        return response()->noContent();
    }
}
