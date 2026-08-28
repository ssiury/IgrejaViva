<?php

namespace App\Modules\SolicitacaoVisita\Exceptions;

use App\Modules\Shared\Exceptions\DomainException;

class CultoNaoEncontradoException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            message: __('solicitacao_visita.culto_nao_encontrado'),
            httpStatusCode: 422,
            errorCode: 'solicitacao_visita_culto_nao_encontrado',
        );
    }
}
