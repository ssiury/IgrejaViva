<?php

namespace App\Modules\Culto\Repositories\Contracts;

use App\Modules\Culto\Models\Culto;
use Illuminate\Support\Collection;

interface CultoRepositoryInterface
{
    public function listarAtivosOrdenados(): Collection;

    public function buscarPorId(int $id): ?Culto;
}
