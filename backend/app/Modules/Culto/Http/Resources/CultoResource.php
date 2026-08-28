<?php

namespace App\Modules\Culto\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CultoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'tag' => $this->tag,
            'horario' => $this->horario_formatado,
            'descricao' => $this->descricao,
        ];
    }
}
