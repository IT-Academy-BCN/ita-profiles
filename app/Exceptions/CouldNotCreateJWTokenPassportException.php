<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class CouldNotCreateJWTokenPassportException extends Exception
{
    public const MESSAGE = 'No ha estat possible generar el JWT usant Passport per a l\'usuari amb ID %s';
    
    public function __construct(string $user_id, $code = 401, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $user_id);
        parent::__construct($message, $code, $previous);
    }
}
