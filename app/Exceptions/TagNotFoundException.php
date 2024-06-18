<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class TagNotFoundException extends Exception
{
    public const MESSAGE = 'No s\'ha trobat cap etiqueta amb aquest ID: %s';

    public function __construct(int $tagId, $code = 404, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $tagId);
        parent::__construct($message, $code, $previous);
    }
}
