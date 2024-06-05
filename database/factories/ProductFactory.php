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
            'user_id' => 2,
            'product_image' => 'assets/default/product.png',
            'product_name' => 'product ' . rand(10000, 99999),
            'weight' => 10,
            'price' => 10000,
            'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate, minus.'
        ];
    }
}
