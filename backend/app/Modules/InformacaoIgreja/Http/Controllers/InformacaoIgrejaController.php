<?php

namespace App\Modules\InformacaoIgreja\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\InformacaoIgreja\Applications\ObterInformacaoIgrejaApplication;
use App\Modules\InformacaoIgreja\Http\Resources\InformacaoIgrejaResource;
use App\Modules\Shared\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class InformacaoIgrejaController extends Controller
{
    public function show(ObterInformacaoIgrejaApplication $obterInformacaoIgrejaApplication): JsonResponse
    {
        return ApiResponse::success(
            new InformacaoIgrejaResource($obterInformacaoIgrejaApplication->executar()),
        );
    }
}
