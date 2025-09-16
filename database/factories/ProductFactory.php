<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'category_id' => fake()->randomElement(Category::pluck('id')->toArray()),
            'stock' => $this->faker->numberBetween(1, 100),       
            'image_url' => $this->faker->imageUrl(640, 480, 'food', true),
        ];
    }
}
