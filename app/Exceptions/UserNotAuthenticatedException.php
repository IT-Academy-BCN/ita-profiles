<?php

namespace App\Exceptions;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;

use Exception;

class UserNotAuthenticatedException extends Exception
{ 
    protected $message;



    public function __construct($message = null  )
    {
        parent::__construct($message ?: 'No autoritzat.'); // Si no pasa mensaje en la exepcion, lanzara este por defecto

     
    }

    public function getHttpCode()
    {
        return Response::HTTP_UNAUTHORIZED; // Código HTTP 401
    }

}
