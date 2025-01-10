<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class ResumeNotFoundException extends Exception
{
    public const MESSAGE = 'No resume found for student id: %s';

    public function __construct(string $studentId, $code = 404, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
