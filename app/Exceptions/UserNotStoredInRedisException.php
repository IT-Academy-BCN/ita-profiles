<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class UserNotStoredInRedisException extends Exception
{
    public const MESSAGE = 'Failed to store JWT in Redis for user with ID %s';

    public function __construct(string $user_id, $code = 401, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $user_id);
        parent::__construct($message, $code, $previous);
    }
}
