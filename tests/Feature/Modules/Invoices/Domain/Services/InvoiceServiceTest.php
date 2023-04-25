<?php

namespace Tests\Feature\Modules\Invoices\Domain\Services;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Infrastructure\Exceptions\InvoiceNotFound;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoiceServiceTest extends TestCase
{
    public function test_get_valid_invoice() {
        $invoice = Invoice::factory()->create();

        $invoiceService = resolve('App\Modules\Invoices\Domain\Services\IInvoiceService');

        $invoiceDB = $invoiceService->getInvoice($invoice->id);

        $this->assertEquals($invoice->id, $invoiceDB->id);
    }

    public function test_get_invalid_invoice() {
        $this->expectException(InvoiceNotFound::class);

        $invoiceService = resolve('App\Modules\Invoices\Domain\Services\IInvoiceService');

        $invoiceService->getInvoice(Uuid::uuid4()->toString());
    }

    public function test_approve_invoice_with_valid_status() {
        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::DRAFT,
        ]);

        $invoiceService = resolve('App\Modules\Invoices\Domain\Services\IInvoiceService');

        $invoiceService->approveInvoice($invoice->id);

        $invoiceDB = $invoiceService->getInvoice($invoice->id);

        $this->assertEquals($invoiceDB->status, StatusEnum::APPROVED->value);
    }

    public function test_approve_invoice_with_invalid_status() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('approval status is already assigned');

        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::REJECTED,
        ]);

        $invoiceService = resolve('App\Modules\Invoices\Domain\Services\IInvoiceService');

        $invoiceService->approveInvoice($invoice->id);
    }

    public function test_reject_invoice_with_valid_status() {
        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::DRAFT,
        ]);

        $invoiceService = resolve('App\Modules\Invoices\Domain\Services\IInvoiceService');

        $invoiceService->rejectInvoice($invoice->id);

        $invoiceDB = $invoiceService->getInvoice($invoice->id);

        $this->assertEquals($invoiceDB->status, StatusEnum::REJECTED->value);
    }

    public function test_reject_invoice_with_invalid_status() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('approval status is already assigned');

        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::APPROVED,
        ]);

        $invoiceService = resolve('App\Modules\Invoices\Domain\Services\IInvoiceService');

        $invoiceService->rejectInvoice($invoice->id);
    }
}
