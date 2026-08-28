<?php

namespace App\Modules\SolicitacaoVisita\Repositories\Contracts;

use App\Modules\SolicitacaoVisita\Models\SolicitacaoVisita;

interface SolicitacaoVisitaRepositoryInterface
{
    public function existeRecentePorEmail(string $email, int $horas): bool;

    public function criar(array $dados): SolicitacaoVisita;
}
