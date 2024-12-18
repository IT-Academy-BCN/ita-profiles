<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidCredentialsException extends Exception
{
<<<<<<< HEAD
    public const MESSAGE = 'Invalid credentials provided by the user';
=======
    public const MESSAGE = 'Les credencials proporcionades per l\'usuari són invàlides.';
>>>>>>> main

    public function __construct($code = 401, Throwable $previous = null)
    {
        parent::__construct(self::MESSAGE, $code, $previous);
    }
}
