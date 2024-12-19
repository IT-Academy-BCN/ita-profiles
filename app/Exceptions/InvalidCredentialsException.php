<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidCredentialsException extends Exception
{
    public const MESSAGE = 'Invalid credentials provided by the user';

    public function __construct($code = 401, Throwable $previous = null)
    {
        parent::__construct(self::MESSAGE, $code, $previous);
    }
}
