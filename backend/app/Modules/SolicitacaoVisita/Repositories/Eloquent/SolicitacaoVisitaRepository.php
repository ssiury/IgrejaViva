<?php

namespace App\Modules\SolicitacaoVisita\Repositories\Eloquent;

use App\Modules\SolicitacaoVisita\Models\SolicitacaoVisita;
use App\Modules\SolicitacaoVisita\Repositories\Contracts\SolicitacaoVisitaRepositoryInterface;
use Illuminate\Support\Carbon;

class SolicitacaoVisitaRepository implements SolicitacaoVisitaRepositoryInterface
{
    public function existeRecentePorEmail(string $email, int $horas): bool
    {
        return SolicitacaoVisita::query()
            ->where('email', $email)
            ->where('created_at', '>=', Carbon::now()->subHours($horas))
            ->exists();
    }

    public function criar(array $dados): SolicitacaoVisita
    {
        return SolicitacaoVisita::query()->create($dados);
    }
}
