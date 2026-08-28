<?php

namespace App\Modules\InformacaoIgreja\Exceptions;

use App\Modules\Shared\Exceptions\DomainException;

class InformacaoIgrejaNaoConfiguradaException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            message: __('informacao_igreja.nao_configurada'),
            httpStatusCode: 404,
            errorCode: 'informacao_igreja_nao_configurada',
        );
    }
}
