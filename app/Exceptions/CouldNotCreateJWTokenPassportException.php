<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class CouldNotCreateJWTokenPassportException extends Exception
{
    public function __construct(string $user_id, $code = 401, Throwable $previous = null)
    {
        // Establecer el idioma 
        App::setLocale('en'); 

        // Obtener el mensaje traducido
        $message = Lang::get('exceptions.could_not_create_jwt', ['id' => $user_id]);

        parent::__construct($message, $code, $previous);
    }
}
