<?php

namespace App\Modules\Invoices\Infrastructure\Exceptions;

use Exception;

class InvalidOperationException extends Exception
{
    public function __construct($message = "You can not perform this action in this entity")
    {
        parent::__construct($message, 405);
    }
}
