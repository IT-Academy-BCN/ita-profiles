<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class StudentLanguageResumeNotFoundException extends Exception
{
    public const MESSAGE = 'Language with id: %s not found for student with id: %s';

    public function __construct(string $studentId, string $languageId, $code = 404, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $languageId, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
