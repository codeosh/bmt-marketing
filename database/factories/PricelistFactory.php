<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pricelist>
 */
class PricelistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pname' => $this->faker->words(3, true), // Generates a product name
            'kind' => $this->faker->randomElement(['Template', 'Bulletin']), // Random kind
            'content' => $this->faker->paragraphs(10, true), // Generates long text content
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
