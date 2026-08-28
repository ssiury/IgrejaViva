<?php

namespace App\Modules\SolicitacaoVisita\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Shared\Http\ApiResponse;
use App\Modules\SolicitacaoVisita\Applications\CriarSolicitacaoVisitaApplication;
use App\Modules\SolicitacaoVisita\Http\Requests\SolicitacaoVisitaRequest;
use App\Modules\SolicitacaoVisita\Http\Resources\SolicitacaoVisitaResource;
use Illuminate\Http\JsonResponse;

class SolicitacaoVisitaController extends Controller
{
    public function store(
        SolicitacaoVisitaRequest $request,
        CriarSolicitacaoVisitaApplication $criarSolicitacaoVisitaApplication,
    ): JsonResponse {
        return ApiResponse::success(
            new SolicitacaoVisitaResource($criarSolicitacaoVisitaApplication->executar($request->validated())),
            201,
        );
    }
}
