<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Factories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\Company;
use App\Modules\Invoices\Domain\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Invoices\Domain\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();

        $company = [
            'id' => Uuid::uuid4()->toString(),
            'name' => $faker->company(),
            'street' => $faker->streetAddress(),
            'city' => $faker->city(),
            'zip' => $faker->postcode(),
            'phone' => $faker->phoneNumber(),
            'email' => $faker->safeEmail(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Company::insert($company);

        return [
            'number' => $faker->uuid(),
            'date' => $faker->date(),
            'due_date' => $faker->date(),
            'company_id' => $company['id'],
            'status' => StatusEnum::cases()[array_rand(StatusEnum::cases())],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
