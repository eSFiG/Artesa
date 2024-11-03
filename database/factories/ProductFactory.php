<?php


namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'price' => fake()->randomFloat(2, 1, 100),
            'quantity_in_stock' => fake()->numberBetween(0, 100),
        ];
    }
}
