<?php

namespace App\Modules\InformacaoIgreja\database\seeders;

use App\Modules\InformacaoIgreja\Models\InformacaoIgreja;
use Illuminate\Database\Seeder;

class InformacaoIgrejaSeeder extends Seeder
{
    public function run(): void
    {
        InformacaoIgreja::query()->updateOrCreate(
            ['id' => 1],
            [
                'endereco' => 'Rua 3, 44 — Jardim Brasil, Goiânia · GO, 74740-530',
                'telefone' => '(62) 9187-6700',
                'email' => 'comunicacaojdbrasil@gmail.com',
                'horario_cultos_resumo' => 'Domingos às 9h30 e 18h · Terças às 15h e 19h30',
                'instagram_url' => 'https://instagram.com',
                'youtube_url' => 'https://youtube.com',
                'whatsapp_url' => 'https://wa.me',
            ],
        );
    }
}
