<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Product> */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->bothify('Gaming product ????-####'),
            'description' => fake()->paragraph(),
            'brand' => fake()->randomElement(config('library.brands')),
            'category' => fake()->randomElement(config('library.categories')),
            'price' => fake()->randomFloat(2, 10, 250),
        ];
    }
}
