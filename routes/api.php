<?php

declare(strict_types=1);

use App\Modules\Invoices\Infrastructure\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(InvoiceController::class)->group(function (): void {
    Route::get('/invoices/{uuid}', 'show')->name('invoices.show');
    Route::post('/invoices/{uuid}/approve', 'approve')->name('invoices.approve');
    Route::post('/invoices/{uuid}/reject', 'reject')->name('invoices.reject');
});
