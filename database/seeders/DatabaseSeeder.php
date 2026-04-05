<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // =====================
        // USERS
        // =====================
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role' => $faker->randomElement(['admin', 'user']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($users);

        // =====================
        // CLIENTS
        // =====================
        $clients = [];
        for ($i = 1; $i <= 8; $i++) {
            $clients[] = [
                'nom' => $faker->company(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('clients')->insert($clients);
        $clientIds = DB::table('clients')->pluck('id')->toArray();

        // =====================
        // PROJECTS
        // =====================
        $projects = [];
        for ($i = 1; $i <= 12; $i++) {
            $projects[] = [
                'nom' => $faker->word() . '_project_' . $i,
                'montant' => $faker->randomFloat(2, 1000, 50000),
                'client_id' => $faker->randomElement($clientIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('projects')->insert($projects);
        $projectIds = DB::table('projects')->pluck('id')->toArray();

        // =====================
        // DEPENSE NOMS
        // =====================
        $depenseNoms = [];
        for ($i = 1; $i <= 15; $i++) {
            $depenseNoms[] = [
                'nom' => $faker->word() . '_' . $i,
                'type' => $faker->randomElement(['fix', 'variable']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('depense_noms')->insert($depenseNoms);
        $depenseNomIds = DB::table('depense_noms')->pluck('id')->toArray();

        // =====================
        // DEPENSES
        // =====================
        $depenses = [];
        for ($i = 1; $i <= 40; $i++) {
            $depenses[] = [
                'valeur' => $faker->randomFloat(2, 10, 2000),
                'date' => $faker->dateTimeBetween('-6 months', 'now'),
                'note' => $faker->sentence(),
                'attachment' => null,
                'attachment_name' => null,
                'depense_noms_id' => $faker->randomElement($depenseNomIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('depenses')->insert($depenses);

        // =====================
        // ENTREES
        // =====================
        $entrees = [];
        for ($i = 1; $i <= 40; $i++) {
            $entrees[] = [
                'valeur' => $faker->randomFloat(2, 50, 5000),
                'date' => $faker->dateTimeBetween('-6 months', 'now'),
                'type' => $faker->randomElement(['project', 'autre']),
                'note' => $faker->sentence(),
                'attachment' => null,
                'attachment_name' => null,
                'project_id' => $faker->boolean(70) ? $faker->randomElement($projectIds) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('entrees')->insert($entrees);

        // =====================
        // SKILLS
        // =====================
        $skillsList = ['PHP', 'Laravel', 'JS', 'React', 'Vue', 'SQL', 'Python', 'Docker', 'Git', 'Linux'];

        $skills = [];
        foreach ($skillsList as $skill) {
            $skills[] = [
                'name' => $skill,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('skills')->insert($skills);
        $skillIds = DB::table('skills')->pluck('id')->toArray();

        // =====================
        // CANDIDATES
        // =====================
        $candidates = [];
        for ($i = 1; $i <= 20; $i++) {
            $candidates[] = [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->numerify('07########'),
                'location' => $faker->city(),
                'availability' => $faker->randomElement(['immediate', '1 month', '2 months']),
                'exp_years' => $faker->numberBetween(0, 10),
                'cv' => 'cv_' . Str::random(10) . '.pdf',
                'linkedIn' => $faker->url(),
                'github' => $faker->url(),
                'portfolio_url' => $faker->url(),
                'recruitment_pipeline' => $faker->randomElement(['new','interview','shortlisted','offer','rejected','hired']),
                'notation' => $faker->numberBetween(1, 10),
                'salary' => $faker->randomFloat(2, 300, 5000),
                'level' => $faker->randomElement(['beginner','intermediate','advanced','expert']),
                'application_date' => $faker->date(),
                'interview_date' => $faker->optional()->date(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('candidates')->insert($candidates);
        $candidateIds = DB::table('candidates')->pluck('id')->toArray();

        // =====================
        // CANDIDATE_SKILL (FIXED - NO LEVEL)
        // =====================
        $pivot = [];

        foreach ($candidateIds as $candidateId) {
            $randomSkills = $faker->randomElements($skillIds, rand(2, 4));

            foreach ($randomSkills as $skillId) {
                $pivot[] = [
                    'candidate_id' => $candidateId,
                    'skill_id' => $skillId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('candidate_skill')->insert($pivot);
    }
}