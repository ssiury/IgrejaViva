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
                'nome' => 'Louvor',
                'descricao' => 'Equipe de música e adoração — sempre com espaço para novos vocais e instrumentistas.',
                'icone' => 'louvor',
                'ordem' => 1,
                'ativo' => true,
            ],
            [
                'nome' => 'Mídia',
                'descricao' => 'Fotos, artes e redes sociais que registram e comunicam o que Deus faz na igreja.',
                'icone' => 'midia',
                'ordem' => 2,
                'ativo' => true,
            ],
            [
                'nome' => 'Transmissão',
                'descricao' => 'Som, imagem e transmissão ao vivo dos cultos, para quem está na igreja e para quem assiste de casa.',
                'icone' => 'transmissao',
                'ordem' => 3,
                'ativo' => true,
            ],
            [
                'nome' => 'Intercessão',
                'descricao' => 'Um grupo dedicado à oração — pela igreja, pelas famílias e por cada pedido que chega até nós.',
                'icone' => 'intercessao',
                'ordem' => 4,
                'ativo' => true,
            ],
            [
                'nome' => 'Acolhida',
                'descricao' => 'A primeira mão que aperta a sua na porta — recepção e cuidado para quem chega, visitante ou membro.',
                'icone' => 'acolhida',
                'ordem' => 5,
                'ativo' => true,
            ],
            [
                'nome' => 'Infantil',
                'descricao' => 'Ensino bíblico e brincadeiras para crianças de 2 a 10 anos, durante todos os cultos de domingo.',
                'icone' => 'infantil',
                'ordem' => 6,
                'ativo' => true,
            ],
            [
                'nome' => 'Dança',
                'descricao' => 'Expressão de louvor através da dança, em apresentações e coreografias nos cultos e eventos especiais.',
                'icone' => 'danca',
                'ordem' => 7,
                'ativo' => true,
            ],
            [
                'nome' => 'Diaconato',
                'descricao' => 'Cuidado prático da casa e das pessoas — organização, apoio logístico e serviço em cada culto.',
                'icone' => 'diaconato',
                'ordem' => 8,
                'ativo' => true,
            ],
        ];

        Ministerio::query()->whereNotIn('nome', array_column($ministerios, 'nome'))->delete();

        foreach ($ministerios as $ministerio) {
            Ministerio::query()->updateOrCreate(['nome' => $ministerio['nome']], $ministerio);
        }
    }
}
