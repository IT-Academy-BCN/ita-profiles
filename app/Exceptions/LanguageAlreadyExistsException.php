<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class LanguageAlreadyExistsException extends Exception
{
    public const MESSAGE = 'Language %s already exists in student profile %s';

    public function __construct($languageId, $studentId, $code = 409, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $languageId, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
