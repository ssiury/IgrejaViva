<?php

namespace App\Modules\Ministerio\Repositories\Contracts;

use Illuminate\Support\Collection;

interface MinisterioRepositoryInterface
{
    public function listarAtivosOrdenados(): Collection;
}
