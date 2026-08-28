<?php

namespace App\Modules\Culto\Applications;

use App\Modules\Culto\Repositories\Contracts\CultoRepositoryInterface;
use Illuminate\Support\Collection;

class ListarCultosApplication
{
    public function __construct(
        private readonly CultoRepositoryInterface $cultoRepository,
    ) {}

    public function executar(): Collection
    {
        return $this->cultoRepository->listarAtivosOrdenados();
    }
}
