<?php

namespace App\Modules\Ministerio\database\seeders;

use App\Modules\Ministerio\Models\Ministerio;
use Illuminate\Database\Seeder;

class MinisterioSeeder extends Seeder
{
    public function run(): void
    {
        $ministerios = [
            [
                'nome' => 'Kids Viva',
                'descricao' => 'Ensino bíblico e brincadeiras para crianças de 2 a 10 anos, durante todos os cultos de domingo.',
                'icone' => 'kids',
                'ordem' => 1,
                'ativo' => true,
            ],
            [
                'nome' => 'Jovens',
                'descricao' => 'Encontros semanais com louvor, conversa franca sobre a vida e discipulado para adolescentes e jovens.',
                'icone' => 'jovens',
                'ordem' => 2,
                'ativo' => true,
            ],
            [
                'nome' => 'Louvor',
                'descricao' => 'Equipe de música e adoração — sempre com espaço para novos vocais e instrumentistas.',
                'icone' => 'louvor',
                'ordem' => 3,
                'ativo' => true,
            ],
            [
                'nome' => 'Células',
                'descricao' => 'Pequenos grupos que se reúnem durante a semana, em casas, para estudar a Palavra e orar juntos.',
                'icone' => 'celulas',
                'ordem' => 4,
                'ativo' => true,
            ],
            [
                'nome' => 'Casais',
                'descricao' => 'Encontros e aconselhamento para fortalecer casamentos em qualquer fase da relação.',
                'icone' => 'casais',
                'ordem' => 5,
                'ativo' => true,
            ],
            [
                'nome' => 'Ação Social',
                'descricao' => 'Doações, mutirões e visitas à comunidade ao redor da igreja — fé que se traduz em cuidado prático.',
                'icone' => 'acao-social',
                'ordem' => 6,
                'ativo' => true,
            ],
        ];

        foreach ($ministerios as $ministerio) {
            Ministerio::query()->updateOrCreate(['nome' => $ministerio['nome']], $ministerio);
        }
    }
}
