<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class StudentLanguageResumeNotFoundException extends Exception
{
    public const MESSAGE = 'No s\'ha trobat l\'idioma amb id: %s per a l\'estudiant amb id: %s';

    public function __construct(string $studentId, string $languageId, $code = 404, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $languageId, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
