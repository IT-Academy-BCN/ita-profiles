<?php

namespace App\Exceptions;

use Exception;

class EmptyAdminListException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('No hi ha administradors a la base de dades'), 404);
    }
}
