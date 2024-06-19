<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ResumeCreateException extends Exception
{
    public function __construct(string $message, int $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
