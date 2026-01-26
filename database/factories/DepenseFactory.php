<?php

namespace Database\Factories;

use App\Models\DepenseNom;
use App\Models\DepenseNom as ModelsDepenseNom;
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
            "valeur" => fake()->numberBetween(1,1),
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'note' => fake()->sentence(),
            'depense_noms_id' => DepenseNom::inRandomOrder()->first()->id,
        ];
    }
}
