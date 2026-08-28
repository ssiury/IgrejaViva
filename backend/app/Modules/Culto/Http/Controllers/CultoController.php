<?php

namespace App\Modules\Culto\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Culto\Applications\ListarCultosApplication;
use App\Modules\Culto\Http\Resources\CultoResource;
use App\Modules\Shared\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class CultoController extends Controller
{
    public function index(ListarCultosApplication $listarCultosApplication): JsonResponse
    {
        return ApiResponse::success(
            CultoResource::collection($listarCultosApplication->executar()),
        );
    }
}
