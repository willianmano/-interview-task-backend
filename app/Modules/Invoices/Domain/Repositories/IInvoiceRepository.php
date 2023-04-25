<?php

namespace App\Modules\Invoices\Domain\Repositories;

use App\Modules\Invoices\Domain\Dto\InvoiceDto;

interface IInvoiceRepository
{
    public function approve(string $uuid): void;

    public function reject(string $uuid): void;

    public function findById(string $uuid): InvoiceDto;
}
