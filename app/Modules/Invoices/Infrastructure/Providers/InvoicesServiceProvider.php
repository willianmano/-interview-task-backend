<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Domain\Repositories\IInvoiceRepository;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepository;
use App\Modules\Invoices\Domain\Services\IInvoiceService;
use App\Modules\Invoices\Domain\Services\InvoiceService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(IInvoiceRepository::class, InvoiceRepository::class);
        $this->app->scoped(IInvoiceService::class, InvoiceService::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            IInvoiceRepository::class,
            IInvoiceService::class,
        ];
    }
}
