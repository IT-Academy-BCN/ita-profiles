<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class ResumeBootcampNotFoundException extends Exception
{
    public const MESSAGE = 'L\'estudiant amb ID: %s no té informat cap Bootcamp al seu currículum';

    public function __construct(string $studentId, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $studentId);
        parent::__construct($message, 404, $previous);
    }
}
