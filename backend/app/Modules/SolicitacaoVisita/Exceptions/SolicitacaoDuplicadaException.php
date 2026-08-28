<?php

namespace App\Modules\SolicitacaoVisita\Exceptions;

use App\Modules\Shared\Exceptions\DomainException;

class SolicitacaoDuplicadaException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            message: __('solicitacao_visita.duplicada'),
            httpStatusCode: 409,
            errorCode: 'solicitacao_visita_duplicada',
        );
    }
}
