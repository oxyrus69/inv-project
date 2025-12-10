<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['elektronik', 'pakaian', 'makanan', 'perabot']),
            'quantity' => fake()->numberBetween(1, 100),
            'price' => fake()->numberBetween(10000, 5000000),
        ];
    }
}
