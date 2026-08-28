<?php

namespace App\Modules\SolicitacaoVisita\Applications;

use App\Modules\Culto\Repositories\Contracts\CultoRepositoryInterface;
use App\Modules\SolicitacaoVisita\Exceptions\CultoNaoEncontradoException;
use App\Modules\SolicitacaoVisita\Exceptions\SolicitacaoDuplicadaException;
use App\Modules\SolicitacaoVisita\Models\SolicitacaoVisita;
use App\Modules\SolicitacaoVisita\Repositories\Contracts\SolicitacaoVisitaRepositoryInterface;

class CriarSolicitacaoVisitaApplication
{
    private const HORAS_JANELA_DUPLICIDADE = 24;

    public function __construct(
        private readonly SolicitacaoVisitaRepositoryInterface $solicitacaoVisitaRepository,
        private readonly CultoRepositoryInterface $cultoRepository,
    ) {}

    public function executar(array $dadosValidados): SolicitacaoVisita
    {
        if (! empty($dadosValidados['culto_id']) && ! $this->cultoRepository->buscarPorId($dadosValidados['culto_id'])) {
            throw new CultoNaoEncontradoException;
        }

        if ($this->solicitacaoVisitaRepository->existeRecentePorEmail($dadosValidados['email'], self::HORAS_JANELA_DUPLICIDADE)) {
            throw new SolicitacaoDuplicadaException;
        }

        $dadosValidados['telefone'] = $this->normalizarTelefone($dadosValidados['telefone']);

        return $this->solicitacaoVisitaRepository->criar($dadosValidados);
    }

    private function normalizarTelefone(string $telefone): string
    {
        return preg_replace('/\D/', '', $telefone);
    }
}
