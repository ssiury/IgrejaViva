<?php

namespace App\Modules\Ministerio\Repositories\Eloquent;

use App\Modules\Ministerio\Models\Ministerio;
use App\Modules\Ministerio\Repositories\Contracts\MinisterioRepositoryInterface;
use Illuminate\Support\Collection;

class MinisterioRepository implements MinisterioRepositoryInterface
{
    public function listarAtivosOrdenados(): Collection
    {
        return Ministerio::query()
            ->where('ativo', true)
            ->orderBy('ordem')
            ->get();
    }
}
