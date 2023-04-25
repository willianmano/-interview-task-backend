<?php

namespace Tests\Feature\Modules\Invoices\Infrastructure\Controllers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Infrastructure\Exceptions\InvoiceNotFound;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    public function test_show_valid_invoice() {
        $invoice = Invoice::factory()->create();

        $response = $this->get(route('invoices.show', $invoice->id));

        $response->assertStatus(200);
    }

    public function test_show_invoice_not_found() {
        $response = $this->get(route('invoices.show', Uuid::uuid4()->toString()));

        $response->assertStatus(404);
    }

    public function test_approve_invoice_with_valid_status() {
        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::DRAFT,
        ]);

        $response = $this->post(route('invoices.approve', $invoice->id));

        $response->assertStatus(200);
    }

    public function test_approve_invoice_with_invalid_status() {
        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::REJECTED,
        ]);

        $response = $this->post(route('invoices.approve', $invoice->id));

        $response->assertStatus(400);
    }

    public function test_reject_invoice_with_valid_status() {
        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::DRAFT,
        ]);

        $response = $this->post(route('invoices.reject', $invoice->id));

        $response->assertStatus(200);
    }

    public function test_reject_invoice_with_invalid_status() {
        $invoice = Invoice::factory()->create([
            'status' => StatusEnum::APPROVED,
        ]);

        $response = $this->post(route('invoices.reject', $invoice->id));

        $response->assertStatus(400);
    }
}
