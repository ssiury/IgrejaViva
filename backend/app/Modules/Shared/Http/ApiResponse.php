<?php

namespace App\Modules\Shared\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResponse
{
    public static function success(
        JsonResource|ResourceCollection|array|null $data = null,
        int $status = 200,
    ): JsonResponse {
        return response()->json([
            'sucesso' => true,
            'dados' => $data,
        ], $status);
    }

    public static function error(
        string $mensagem,
        int $status,
        ?string $codigoErro = null,
        array $erros = [],
    ): JsonResponse {
        return response()->json([
            'sucesso' => false,
            'mensagem' => $mensagem,
            'codigo_erro' => $codigoErro,
            'erros' => $erros,
        ], $status);
    }
}
