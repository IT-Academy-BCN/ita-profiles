<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidCredentialsException extends Exception
{
    public const MESSAGE = 'Credencials invàlides proporcionades per l\'usuari.';

    public function __construct($code = 401, Throwable $previous = null)
    {
        parent::__construct(self::MESSAGE, $code, $previous);
    }
}
