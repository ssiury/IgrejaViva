<?php

namespace App\Modules\Culto\database\seeders;

use App\Modules\Culto\Models\Culto;
use Illuminate\Database\Seeder;

class CultoSeeder extends Seeder
{
    public function run(): void
    {
        $cultos = [
            [
                'titulo' => 'Culto de Celebração',
                'tag' => 'Domingo · Manhã',
                'horario' => '09:00',
                'descricao' => 'Louvor, Palavra e Santa Ceia no primeiro domingo do mês. Espaço kids para crianças de 2 a 10 anos.',
                'ordem' => 1,
                'ativo' => true,
            ],
            [
                'titulo' => 'Culto da Família',
                'tag' => 'Domingo · Noite',
                'horario' => '19:00',
                'descricao' => 'Um culto mais intimista, voltado à Palavra e à ministração — ideal para quem está chegando.',
                'ordem' => 2,
                'ativo' => true,
            ],
            [
                'titulo' => 'Culto de Oração',
                'tag' => 'Quarta-feira',
                'horario' => '20:00',
                'descricao' => 'Um momento para buscar a Deus juntos, orar pela vida uns dos outros e respirar no meio da semana.',
                'ordem' => 3,
                'ativo' => true,
            ],
        ];

        foreach ($cultos as $culto) {
            Culto::query()->updateOrCreate(['titulo' => $culto['titulo']], $culto);
        }
    }
}
