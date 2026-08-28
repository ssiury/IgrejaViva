<?php

namespace App\Modules\InformacaoIgreja\Applications;

use App\Modules\InformacaoIgreja\Exceptions\InformacaoIgrejaNaoConfiguradaException;
use App\Modules\InformacaoIgreja\Models\InformacaoIgreja;
use App\Modules\InformacaoIgreja\Repositories\Contracts\InformacaoIgrejaRepositoryInterface;

class ObterInformacaoIgrejaApplication
{
    public function __construct(
        private readonly InformacaoIgrejaRepositoryInterface $informacaoIgrejaRepository,
    ) {}

    public function executar(): InformacaoIgreja
    {
        return $this->informacaoIgrejaRepository->obterAtual()
            ?? throw new InformacaoIgrejaNaoConfiguradaException;
    }
}
