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
                'titulo' => 'Escola Bíblica Dominical',
                'tag' => 'Domingo · Manhã',
                'horario' => '09:30',
                'descricao' => 'Um tempo de estudo e aprofundamento na Palavra em turmas por idade, antes do culto de celebração.',
                'ordem' => 1,
                'ativo' => true,
            ],
            [
                'titulo' => 'Culto da Família',
                'tag' => 'Domingo · Noite',
                'horario' => '18:00',
                'descricao' => 'Um culto mais intimista, voltado à Palavra e à ministração — ideal para quem está chegando.',
                'ordem' => 2,
                'ativo' => true,
            ],
            [
                'titulo' => 'Tarde da Benção',
                'tag' => 'Terça-Feira · Tarde',
                'horario' => '15:00',
                'descricao' => 'Um momento de oração, louvor e ministração para quem busca um tempo com Deus no meio da tarde.',
                'ordem' => 3,
                'ativo' => true,
            ],
            [
                'titulo' => 'Células',
                'tag' => 'Terça-Feira · Noite',
                'horario' => '19:30',
                'descricao' => 'Encontros em pequenos grupos nos lares, para comunhão, estudo da Palavra e oração uns pelos outros.',
                'ordem' => 4,
                'ativo' => true,
            ],
        ];

        Culto::query()->whereNotIn('titulo', array_column($cultos, 'titulo'))->delete();

        foreach ($cultos as $culto) {
            Culto::query()->updateOrCreate(['titulo' => $culto['titulo']], $culto);
        }
    }
}
