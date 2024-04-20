<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ModalityNotFoundException extends Exception
{
    public function __construct($studentId, $code = 0, Throwable $previous = null)
    {
        $message = "L'estudiant amb ID: " . $studentId . " no té informada la modalitat al seu currículum";
        parent::__construct($message, $code, $previous);
    }
}
