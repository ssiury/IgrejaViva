<?php

namespace App\Modules\InformacaoIgreja\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InformacaoIgrejaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'endereco' => $this->endereco,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'horario_cultos_resumo' => $this->horario_cultos_resumo,
            'redes_sociais' => [
                'instagram' => $this->instagram_url,
                'youtube' => $this->youtube_url,
                'whatsapp' => $this->whatsapp_url,
            ],
        ];
    }
}
