<?php

namespace App\Modules\SolicitacaoVisita\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoVisita extends Model
{
    protected $table = 'solicitacoes_visita';

    protected $fillable = [
        'nome',
        'telefone',
        'email',
        'culto_id',
        'mensagem',
    ];
}
