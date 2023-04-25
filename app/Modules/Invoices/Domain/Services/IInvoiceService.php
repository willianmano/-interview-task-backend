<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Services;

use App\Modules\Invoices\Domain\Dto\InvoiceDto;

interface IInvoiceService
{
    public function getInvoice(string $uuid): InvoiceDto;
    public function approveInvoice(string $uuid): void;
    public function rejectInvoice(string $uuid): void;
}
