<?php

namespace Database\Factories; // Correct namespace

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QuotationCustomer; // Import the model

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuotationCustomer>
 */
class QuotationCustomerFactory extends Factory
{
    /**
     * The name of the model that this factory is for.
     *
     * @var string
     */
    protected $model = QuotationCustomer::class; // model where you but your tbl_customers

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nos' => $this->faker->unique()->randomNumber(5, true),
            'customer_name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'contact' => $this->faker->phoneNumber(),
        ];
    }
}
