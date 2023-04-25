<?php

namespace App\Modules\Invoices\Infrastructure\Exceptions;

use Exception;

class InvoiceNotFound extends Exception
{
    public function __construct($message = "Invoice not found")
    {
        parent::__construct($message, 404);
    }
}
