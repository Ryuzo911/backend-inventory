<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "product_id" => fake()->randomElement(Product::pluck("id")),
            "type" => $this->faker->randomElement(["in", "out"]),
            "quantity" => $this->faker->numberBetween(1, 100),
            "created_by" => fake()->randomElement(User::pluck("id")),
        ];
    }
}
