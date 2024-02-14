<?php

namespace App\Exceptions;

use Exception;

class DuplicateResumeException extends Exception
{
    protected $message;

    public function __construct($message = null)
    {
        parent::__construct($message ?: 'Un estudiant només pot tenir un currículum.'); 

    }
}