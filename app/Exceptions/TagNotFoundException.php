<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class TagNotFoundException extends Exception
{
    public const MESSAGE = 'No tags found with this ID: %s';

    public function __construct(int $tagId, $code = 404, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $tagId);
        parent::__construct($message, $code, $previous);
    }
}
