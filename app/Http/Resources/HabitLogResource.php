<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HabitLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Serve para formatar os dados exibidos na API, se n passar nada vai todos os campos da tabela
        return [
            'uuid' => $this->uuid,
            'completed_at' => $this->completed_at,
        ];
        
    }
}
