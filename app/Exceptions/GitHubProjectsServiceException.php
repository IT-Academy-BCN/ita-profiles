<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class GitHubProjectsServiceException extends Exception
{
    public const MESSAGE = 'GitHub API exception for project ID "%s"';

    public function __construct(string $projectId, $code = 500, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $projectId);
        parent::__construct($message, $code, $previous);
    }
}
