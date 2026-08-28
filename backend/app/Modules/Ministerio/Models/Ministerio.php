<?php

namespace App\Modules\Ministerio\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministerio extends Model
{
    use HasFactory;

    protected $table = 'ministerios';

    protected $fillable = [
        'nome',
        'descricao',
        'icone',
        'ordem',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ordem' => 'integer',
            'ativo' => 'boolean',
        ];
    }
}
