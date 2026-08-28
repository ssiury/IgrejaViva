<?php

namespace App\Modules\Ministerio\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Ministerio\Applications\ListarMinisteriosApplication;
use App\Modules\Ministerio\Http\Resources\MinisterioResource;
use App\Modules\Shared\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class MinisterioController extends Controller
{
    public function index(ListarMinisteriosApplication $listarMinisteriosApplication): JsonResponse
    {
        return ApiResponse::success(
            MinisterioResource::collection($listarMinisteriosApplication->executar()),
        );
    }
}
