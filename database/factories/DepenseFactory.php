<?php

namespace Database\Factories;

use App\Models\Depensenom;
use App\Models\Depensenom as ModelsDepensenom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Depense>
 */
class DepenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "valeur" => fake()->numberBetween(100,5000),
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'note' => fake()->sentence(),
            'depensenom_id' => Depensenom::inRandomOrder()->first()->id,
        ];
    }
}
