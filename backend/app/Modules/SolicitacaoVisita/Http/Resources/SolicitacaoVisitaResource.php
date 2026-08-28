<?php

namespace App\Modules\SolicitacaoVisita\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitacaoVisitaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'culto_id' => $this->culto_id,
            'mensagem' => $this->mensagem,
            'criado_em' => $this->created_at,
        ];
    }
}
