<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class StudentNotFoundException extends Exception
{
    public const MESSAGE = 'No se ha encontrado ningun estudiante con ID: %s';

    public function __construct(string | int $studentId, $code = 404, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
