<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class StudentNotFoundException extends Exception
{
    public const MESSAGE = 'No s\'ha trobat cap estudiant amb aquest ID: %s';

    public function __construct($studentId, $code = 0, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
