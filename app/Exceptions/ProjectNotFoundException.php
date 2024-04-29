<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ProjectNotFoundException extends Exception
{
    public const MESSAGE = 'No s\'ha trobat cap Resume associat a aquest estudiant amb ID: %s';

    public function __construct($studentId, $code = 0, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
