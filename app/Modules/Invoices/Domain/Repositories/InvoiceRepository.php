<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Dto\InvoiceDto;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Infrastructure\Exceptions\InvalidOperationException;
use App\Modules\Invoices\Infrastructure\Exceptions\InvoiceNotFound;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class InvoiceRepository implements IInvoiceRepository
{
    public function findById(string $uuid): InvoiceDto
    {
        $invoice = Invoice::find($uuid);

        if (!$invoice) {
            throw new InvoiceNotFound();
        }

        return new InvoiceDto(
            Uuid::fromString($invoice->id),
            $invoice->number,
            $invoice->date,
            $invoice->due_date,
            Uuid::fromString($invoice->company_id),
            $invoice->status
        );
    }

    public function approve(string $uuid): void
    {
        $invoice = $this->findById($uuid);

        if (StatusEnum::REJECTED->value == $invoice->status) {
            throw new InvalidOperationException();
        }

        $this->updateInvoice($invoice->id, ['status' => StatusEnum::APPROVED]);
    }

    public function reject(string $uuid): void
    {
        $invoice = $this->findById($uuid);

        if (StatusEnum::APPROVED->value == $invoice->status) {
            throw new InvalidOperationException();
        }

        $this->updateInvoice($invoice->id, ['status' => StatusEnum::REJECTED]);
    }

    public function updateInvoice(UuidInterface $id, array $fields): void
    {
        Invoice::where('id', $id->toString())
            ->update($fields);
    }
}
