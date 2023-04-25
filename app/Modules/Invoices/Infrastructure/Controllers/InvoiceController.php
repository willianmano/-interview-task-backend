<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Domain\Services\IInvoiceService;
use Exception;
use Illuminate\Http\Request;
use LogicException;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    private $invoiceService;

    public function __construct(IInvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function show(Request $request)
    {
        try {
            $invoice = $this->invoiceService->getInvoice($request->route('uuid'));

            return response()->json($invoice, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function approve(Request $request)
    {
        try {
            $this->invoiceService->approveInvoice($request->route('uuid'));

            return response()->json(['message' => 'Invoice approved'], Response::HTTP_OK);
        } catch (LogicException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function reject(Request $request)
    {
        try {
            $this->invoiceService->rejectInvoice($request->route('uuid'));

            return response()->json(['message' => 'Invoice rejected'], Response::HTTP_OK);
        } catch (LogicException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
