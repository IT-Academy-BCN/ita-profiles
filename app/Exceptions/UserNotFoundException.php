<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class UserNotFoundException extends Exception
{
    public const MESSAGE = 'No user was found with this ID: %s';

    public function __construct(string $userDNI, $code = 401, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $userDNI);
        parent::__construct($message, $code, $previous);
    }
}
