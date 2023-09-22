<?php

namespace Database\Factories;

use App\Models\Product;
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
        $name = fake()->colorName();
        return [
            'name' => $name,
            'price' => fake()->numberBetween(1000, 10000),
            'image_url' => fake()->imageUrl(
                randomize: false,
                word: $name
            ),
            'code' => 'SOME-rand0m-c0d3',
            'package_code' => 'soME-rand0m-packag3-c0d3',
            'vat_percent' => Product::VAT_PERCENT
        ];
    }
}
