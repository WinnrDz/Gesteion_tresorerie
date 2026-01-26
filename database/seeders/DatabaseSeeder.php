<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\DepenseNom;
use App\Models\Project;
use App\Models\Entree;
use App\Models\Depense;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Entree::factory()->create([
                    'type' => 'autre',
                ]);
        DepenseNom::factory(100)->create();

        Project::factory(100)->create();

        $projects = Project::all();

        foreach ($projects as $project) {
            $currentSum = Entree::where('project_id', $project->id)->sum('valeur');
            $maxToAdd = $project->montant - $currentSum;

            while ($maxToAdd > 0) {
                // Randomly stop filling early
                if (fake()->boolean(30)) { // 30% chance to stop
                    break;
                }

                $valeur = fake()->numberBetween(1, min($maxToAdd, $project->montant / 2));

                Entree::factory()->create([
                    'project_id' => $project->id,
                    'valeur' => $valeur,
                    'type' => 'project',
                ]);

                $maxToAdd -= $valeur;
            }
        }

        Depense::factory(100)->create();
    }
}
