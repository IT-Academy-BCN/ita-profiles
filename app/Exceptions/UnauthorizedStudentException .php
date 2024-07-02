<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class UnauthorizedStudentException extends Exception
{
    public const MESSAGE = 'L\'estudiant amb ID %s no està autoritzat a realitzar aquesta operació.';

    public function __construct(string $studentId, $code = 403, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
