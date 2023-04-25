<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Dto;

use Ramsey\Uuid\UuidInterface;

final readonly class InvoiceDto
{
    public function __construct(
        public UuidInterface $id,
        public string $number,
        public string $date,
        public string $dueDate,
        public UuidInterface $companyId,
        public string $status
    ) {
    }
}
