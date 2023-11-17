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
            'category_id' => Category::all()->random(),
            'title' => fake()->name(),
            'price' => fake()->randomDigit(),
            'quantity' => rand(1, 100),
            'image' => fake()->imageUrl(),
            'weight' => rand(1000, 99999),
            'description' => fake()->sentence(),
        ];
    }
}
