<?php

namespace App\Modules\InformacaoIgreja\Repositories\Contracts;

use App\Modules\InformacaoIgreja\Models\InformacaoIgreja;

interface InformacaoIgrejaRepositoryInterface
{
    public function obterAtual(): ?InformacaoIgreja;
}
