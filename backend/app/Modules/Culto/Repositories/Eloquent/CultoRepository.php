<?php

namespace App\Modules\Culto\Repositories\Eloquent;

use App\Modules\Culto\Models\Culto;
use App\Modules\Culto\Repositories\Contracts\CultoRepositoryInterface;
use Illuminate\Support\Collection;

class CultoRepository implements CultoRepositoryInterface
{
    public function listarAtivosOrdenados(): Collection
    {
        return Culto::query()
            ->where('ativo', true)
            ->orderBy('ordem')
            ->get();
    }

    public function buscarPorId(int $id): ?Culto
    {
        return Culto::query()->find($id);
    }
}
