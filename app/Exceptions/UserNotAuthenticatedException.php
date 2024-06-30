<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UserNotAuthenticatedException extends Exception
{
    protected $message;

    public function __construct($message = null)
    {
        parent::__construct($message ?: 'No autoritzat.'); // Si no pasa mensaje en la exepcion, lanzara este por defecto

    }

    public function getHttpCode()
    {
        return Response::HTTP_UNAUTHORIZED; // Código HTTP 401
    }
}
