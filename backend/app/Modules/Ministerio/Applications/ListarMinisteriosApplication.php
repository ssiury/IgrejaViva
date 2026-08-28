<?php

namespace App\Modules\Ministerio\Applications;

use App\Modules\Ministerio\Repositories\Contracts\MinisterioRepositoryInterface;
use Illuminate\Support\Collection;

class ListarMinisteriosApplication
{
    public function __construct(
        private readonly MinisterioRepositoryInterface $ministerioRepository,
    ) {}

    public function executar(): Collection
    {
        return $this->ministerioRepository->listarAtivosOrdenados();
    }
}
