<?php

namespace Database\Factories;

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
            'name' => ucfirst(fake()->word()),
            'description' => fake()->sentences(5, true),
            'price' => rand(1,1000),
            'user_id' => rand(1,3),
            'company_id' => rand(1,5),
            'category_id' => rand(1,5)
        ];
    }
}
