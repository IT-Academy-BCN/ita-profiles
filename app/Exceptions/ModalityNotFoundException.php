<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class ModalityNotFoundException extends Exception
{
    public const MESSAGE = 'L\'estudiant amb ID: %s no té informada la modalitat al seu currículum';

    public function __construct($studentId, $code = 0, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $studentId);
        parent::__construct($message, $code, $previous);
    }
}
