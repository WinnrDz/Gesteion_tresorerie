<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entree>
 */
class EntreeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'valeur' => fake()->numberBetween(500,10000),
            'date' =>fake()->dateTimeBetween('-1 year','now'),
            'type'=>fake()->randomElement(['project','autre']),
            'note' => fake()->sentence(),
            'project_id' => Project::inRandomOrder()->First()?->id,
        ];
    }
}
