<?php

namespace App\Modules\Culto\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Culto extends Model
{
    use HasFactory;

    protected $table = 'cultos';

    protected $fillable = [
        'titulo',
        'tag',
        'horario',
        'descricao',
        'ordem',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'horario' => 'datetime:H:i',
            'ordem' => 'integer',
            'ativo' => 'boolean',
        ];
    }

    protected function horarioFormatado(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->horario->format('H\hi'),
        );
    }
}
