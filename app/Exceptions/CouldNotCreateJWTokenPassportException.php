<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class CouldNotCreateJWTokenPassportException extends Exception
{
    public const MESSAGE = 'It was not possible to generate the JWT using Passport for the user with ID %id';
    
    public function __construct(string $user_id, $code = 401, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $user_id);
        parent::__construct($message, $code, $previous);
    }
}
