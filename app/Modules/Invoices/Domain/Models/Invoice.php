<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Invoice extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'number',
        'date',
        'due_date',
        'company_id',
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice): void {
            $invoice->incrementing = false;
            $invoice->{$invoice->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
}
