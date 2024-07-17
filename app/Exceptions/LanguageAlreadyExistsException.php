<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class LanguageAlreadyExistsException extends Exception
{
    public const MESSAGE = 'L\'idioma %s ja existeix al perfil de l\'estudiant %s';

    public function __construct($languageId, $studentId, $code = 409, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $languageId, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
