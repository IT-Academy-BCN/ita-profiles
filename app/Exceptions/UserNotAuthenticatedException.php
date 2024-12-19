<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UserNotAuthenticatedException extends Exception
{
    protected $message;

    public function __construct($message = null)
    {
        parent::__construct($message ?: 'Not authorized'); /
    }

    public function getHttpCode()
    {
        return Response::HTTP_UNAUTHORIZED; 
    }
}
