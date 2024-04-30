<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class StudentNotFoundException extends Exception
{
    public const MESSAGE = 'No s\'ha trobat cap estudiant amb aquest ID: %s';

    public function __construct(string $studentId, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $studentId);
        parent::__construct($message, 404, $previous);
    }
}
