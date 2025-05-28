<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HabitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Serve para formatar os dados exibidos na API 
        // Usa make para retornar UM unico registro (modelo-objeto)
        // Usa Collection para retornar +1
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'user' => UserResource::make($this->whenLoaded('user')),
            'logs' => HabitLogResource::collection($this->whenLoaded('logs')),
            'links' => [
                'self' => route('api.habits.show', $this),
                'logs' => route('api.habits.logs.index', $this),
            ]
        ];
    }
}
