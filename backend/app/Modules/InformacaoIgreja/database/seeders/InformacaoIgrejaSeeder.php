<?php

namespace App\Modules\InformacaoIgreja\database\seeders;

use App\Modules\InformacaoIgreja\Models\InformacaoIgreja;
use Illuminate\Database\Seeder;

class InformacaoIgrejaSeeder extends Seeder
{
    public function run(): void
    {
        InformacaoIgreja::query()->updateOrCreate(
            ['email' => 'contato@igrejaviva.org'],
            [
                'endereco' => 'Rua das Palmeiras, 250 — Setor Central, Goiânia · GO',
                'telefone' => '(62) 3000-0000',
                'email' => 'contato@igrejaviva.org',
                'horario_cultos_resumo' => 'Domingos às 9h e 19h · Quartas às 20h',
                'instagram_url' => 'https://instagram.com',
                'youtube_url' => 'https://youtube.com',
                'whatsapp_url' => 'https://wa.me',
            ],
        );
    }
}
