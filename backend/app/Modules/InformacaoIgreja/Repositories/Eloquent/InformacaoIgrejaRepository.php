<?php

namespace App\Modules\InformacaoIgreja\Repositories\Eloquent;

use App\Modules\InformacaoIgreja\Models\InformacaoIgreja;
use App\Modules\InformacaoIgreja\Repositories\Contracts\InformacaoIgrejaRepositoryInterface;

class InformacaoIgrejaRepository implements InformacaoIgrejaRepositoryInterface
{
    public function obterAtual(): ?InformacaoIgreja
    {
        return InformacaoIgreja::query()->first();
    }
}
