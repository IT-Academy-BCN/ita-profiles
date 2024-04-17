<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ModalityNotFoundException extends Exception
{
    public function __construct($studentId, $code = 0, Throwable $previous = null)
    {
        $message = 'No se encontrado ningún currículum para el estudiante con id: ' . $studentId;
        parent::__construct($message, $code, $previous);
    }
}
