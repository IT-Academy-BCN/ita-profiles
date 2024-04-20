<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class StudentNotFoundException extends Exception
{
    public function __construct($studentId, $code = 0, Throwable $previous = null)
    {
        $message = "No s'ha trobat cap estudiant amb aquest ID " . $studentId;
        parent::__construct($message, $code, $previous);
    }
}
