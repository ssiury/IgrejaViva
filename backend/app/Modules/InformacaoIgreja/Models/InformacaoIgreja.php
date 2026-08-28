<?php

namespace App\Modules\InformacaoIgreja\Models;

use Illuminate\Database\Eloquent\Model;

class InformacaoIgreja extends Model
{
    protected $table = 'informacoes_igreja';

    protected $fillable = [
        'endereco',
        'telefone',
        'email',
        'horario_cultos_resumo',
        'instagram_url',
        'youtube_url',
        'whatsapp_url',
    ];
}
