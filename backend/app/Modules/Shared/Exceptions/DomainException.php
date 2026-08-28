<?php

namespace App\Modules\Shared\Exceptions;

use RuntimeException;

abstract class DomainException extends RuntimeException
{
    public function __construct(
        string $message,
        private readonly int $httpStatusCode,
        private readonly string $errorCode,
    ) {
        parent::__construct($message);
    }

    public function httpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function errorCode(): string
    {
        return $this->errorCode;
    }
}
