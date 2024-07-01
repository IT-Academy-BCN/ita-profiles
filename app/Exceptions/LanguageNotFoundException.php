<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class LanguageNotFoundException extends Exception
{
    public const MESSAGE = 'L\'estudiant amb ID: %s no té informat cap idioma al seu currículum';

    public function __construct($studentId, $code = 404, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
