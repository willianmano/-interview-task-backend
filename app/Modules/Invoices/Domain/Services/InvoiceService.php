<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Services;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Domain\Dto\InvoiceDto;
use App\Modules\Invoices\Domain\Repositories\IInvoiceRepository;
use Ramsey\Uuid\Uuid;

class InvoiceService implements IInvoiceService
{
    private $invoiceRepository;
    private $approvalService;

    public function __construct(IInvoiceRepository $invoiceRepository, ApprovalFacadeInterface $approvalService)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->approvalService = $approvalService;
    }

    public function getInvoice(string $uuid): InvoiceDto
    {
        return $this->invoiceRepository->findById($uuid);
    }

    public function approveInvoice(string $uuid): void
    {
        $invoice = $this->getInvoice($uuid);

        $this->approvalService->approve(
            new ApprovalDto(
                Uuid::fromString($uuid),
                StatusEnum::tryFrom($invoice->status),
                'invoice'
            )
        );

        $this->invoiceRepository->approve($uuid);
    }

    public function rejectInvoice(string $uuid): void
    {
        $invoice = $this->getInvoice($uuid);

        $this->approvalService->reject(
            new ApprovalDto(
                Uuid::fromString($uuid),
                StatusEnum::tryFrom($invoice->status),
                'invoice'
            )
        );

        $this->invoiceRepository->reject($uuid);
    }
}
