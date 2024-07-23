<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class LanguageNotFoundException extends Exception
{
    public const MESSAGE = 'Aquest idioma no es troba a la llista d\'idiomes disponibles';

    public function __construct($languageId, $code = 404, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $languageId);
        parent::__construct($message, $code, $previous);
    }
}
