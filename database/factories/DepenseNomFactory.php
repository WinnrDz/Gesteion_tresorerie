<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use PhpParser\Node\Expr\Variable;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DepenseNom>
 */
class DepenseNomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nom" => fake()->unique()->word(),
            'type' => fake()->randomElement(['fix','variable'])
        ];
    }
}
