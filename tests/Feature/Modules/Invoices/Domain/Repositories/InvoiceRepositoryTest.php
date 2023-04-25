<?php

namespace Tests\Feature\Modules\Invoices\Domain\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Infrastructure\Exceptions\InvalidOperationException;
use App\Modules\Invoices\Infrastructure\Exceptions\InvoiceNotFound;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoiceRepositoryTest extends TestCase
{
    public function test_find_valid_invoice() {
        $invoice = Invoice::factory()->create();

        $invoiceRepository = resolve('App\Modules\Invoices\Domain\Repositories\IInvoiceRepository');

        $invoiceDB = $invoiceRepository->findById($invoice->id);

        $this->assertEquals($invoice->id, $invoiceDB->id);
    }

    public function test_get_invalid_invoice() {
        $this->expectException(InvoiceNotFound::class);

        $invoiceRepository = resolve('App\Modules\Invoices\Domain\Repositories\IInvoiceRepository');

        $invoiceRepository->findById(Uuid::uuid4()->toString());
    }

    public function test_approve_invoice_with_valid_status() {
        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::DRAFT,
        ]);

        $invoiceRepository = resolve('App\Modules\Invoices\Domain\Repositories\IInvoiceRepository');

        $invoiceRepository->approve($invoice->id);

        $invoiceDB = $invoiceRepository->findById($invoice->id);

        $this->assertEquals($invoiceDB->status, StatusEnum::APPROVED->value);
    }

    public function test_approve_invoice_with_invalid_status() {
        $this->expectException(InvalidOperationException::class);

        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::REJECTED,
        ]);

        $invoiceRepository = resolve('App\Modules\Invoices\Domain\Repositories\IInvoiceRepository');

        $invoiceRepository->approve($invoice->id);
    }

    public function test_reject_invoice_with_valid_status() {
        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::DRAFT,
        ]);

        $invoiceRepository = resolve('App\Modules\Invoices\Domain\Repositories\IInvoiceRepository');

        $invoiceRepository->reject($invoice->id);

        $invoiceDB = $invoiceRepository->findById($invoice->id);

        $this->assertEquals($invoiceDB->status, StatusEnum::REJECTED->value);
    }

    public function test_reject_invoice_with_invalid_status() {
        $this->expectException(InvalidOperationException::class);

        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::APPROVED,
        ]);

        $invoiceRepository = resolve('App\Modules\Invoices\Domain\Repositories\IInvoiceRepository');

        $invoiceRepository->reject($invoice->id);
    }
}
