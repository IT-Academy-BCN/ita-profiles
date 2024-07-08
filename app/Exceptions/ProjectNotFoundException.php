<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class ProjectNotFoundException extends Exception
{
    public const MESSAGE = 'No s\'ha trobat cap projecte amb aquest ID: %s';

    public function __construct(string $projectId, $code = 404, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $projectId);
        parent::__construct($message, $code, $previous);
    }
}
