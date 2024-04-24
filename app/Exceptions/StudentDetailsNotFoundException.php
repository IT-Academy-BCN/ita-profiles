<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class StudentDetailsNotFoundException extends Exception
{
    public const MESSAGE = 'No s\'ha trobat cap detail amb aquest ID: %s';

    public function __construct($student, $code = 0, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $student);
        parent::__construct($message, $code, $previous);
    }
}