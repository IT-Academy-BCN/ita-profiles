<?php

namespace App\Exceptions;

use DomainException;
use Throwable;

class UserRegisterException extends DomainException
{
    protected $input;

    public function __construct(string $message, array $input, int $code = 500, Throwable $previous = null)
    {
        $this->input = $input;
        parent::__construct($message, $code, $previous);
    }

    public function getInput(): array
    {
        return $this->input;
    }
}
