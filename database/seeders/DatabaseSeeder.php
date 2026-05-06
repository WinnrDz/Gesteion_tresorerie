<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('candidate_profilecv')->truncate();
        DB::table('candidate_skill')->truncate();
        DB::table('profilecvs')->truncate();
        DB::table('skills')->truncate();
        DB::table('candidates')->truncate();
        DB::table('entrees')->truncate();
        DB::table('projects')->truncate();
        DB::table('clients')->truncate();
        DB::table('depenses')->truncate();
        DB::table('depense_noms')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HR Manager',
                'email' => 'hr@test.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | CLIENTS
        |--------------------------------------------------------------------------
        */
        $companyNames = [
            'Sonatrach','Djezzy','Ooredoo','Condor','Cevital',
            'Air Algérie','Mobilis','Naftal','Cosider','Alliance Assurances'
        ];

        $clients = [];
        foreach ($companyNames as $name) {
            $clients[] = [
                'nom' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('clients')->insert($clients);

        $clientIds = DB::table('clients')->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | PROJECTS
        |--------------------------------------------------------------------------
        */
        $projectNames = [
            'ERP System','Mobile App','E-commerce Platform',
            'HR Management System','Payment Gateway',
            'Inventory System','Booking Platform'
        ];

        $projects = [];
        for ($i = 0; $i < 15; $i++) {
            $projects[] = [
                'nom' => $projectNames[array_rand($projectNames)] . " v" . rand(1,3) . " #".$i,
                'montant' => rand(50000, 500000),
                'client_id' => $clientIds->random(),
                'created_at' => Carbon::now()->subMonths(rand(1, 12)),
                'updated_at' => now(),
            ];
        }

        DB::table('projects')->insert($projects);

        $projectIds = DB::table('projects')->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | DEPENSE NOMS
        |--------------------------------------------------------------------------
        */
        DB::table('depense_noms')->insert([
            ['nom' => 'Office Rent', 'type' => 'fix', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Employee Salaries', 'type' => 'fix', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Marketing Ads', 'type' => 'variable', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Software Licenses', 'type' => 'variable', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $depenseNomIds = DB::table('depense_noms')->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | DEPENSES
        |--------------------------------------------------------------------------
        */
        $depenses = [];
        for ($i = 0; $i < 40; $i++) {
            $depenses[] = [
                'valeur' => rand(10000, 200000),
                'date' => Carbon::now()->subDays(rand(1, 180)),
                'note' => 'Expense ' . $i,
                'attachment' => null,
                'attachment_name' => null,
                'depense_noms_id' => $depenseNomIds->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('depenses')->insert($depenses);

        /*
        |--------------------------------------------------------------------------
        | ENTREES (FIX UNIQUE NOTE)
        |--------------------------------------------------------------------------
        */
        $entrees = [];
        for ($i = 0; $i < 40; $i++) {
            $isProject = rand(0, 100) < 80;

            $baseNote = $isProject ? 'Project payment' : 'Other income';

            $entrees[] = [
                'valeur' => rand(20000, 300000),
                'date' => Carbon::now()->subDays(rand(1, 180)),
                'type' => $isProject ? 'project' : 'autre',
                'note' => $baseNote . " #" . $i, // ✅ UNIQUE
                'attachment' => null,
                'attachment_name' => null,
                'project_id' => $isProject ? $projectIds->random() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('entrees')->insert($entrees);

        /*
        |--------------------------------------------------------------------------
        | SKILLS
        |--------------------------------------------------------------------------
        */
        $skills = ['Laravel','React','Vue','PHP','MySQL','JavaScript','NodeJS','Docker','AWS'];
        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'name' => $skill,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $skillIds = DB::table('skills')->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | PROFILE CVS
        |--------------------------------------------------------------------------
        */
        $profiles = [
            'Frontend Developer','Backend Developer','Fullstack Developer',
            'DevOps Engineer','UI/UX Designer','Mobile Developer'
        ];

        foreach ($profiles as $p) {
            DB::table('profilecvs')->insert([
                'name' => $p,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $profileIds = DB::table('profilecvs')->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | CANDIDATES
        |--------------------------------------------------------------------------
        */
        $firstNames = ['Mohamed','Youssef','Amine','Rania','Sara','Omar','Yasmine','Karim','Nassim','Lina'];
        $lastNames = ['Benali','Kaci','Meziane','Bennani','Haddad','Cherif','Bouaziz','Farhi'];

        $candidates = [];

        for ($i = 0; $i < 40; $i++) {

            $first = $firstNames[array_rand($firstNames)];
            $last = $lastNames[array_rand($lastNames)];

            $exp = rand(0, 10);
            $salary = 40000 + ($exp * rand(5000, 12000));

            $level = match(true) {
                $exp <= 1 => 'beginner',
                $exp <= 4 => 'intermediate',
                $exp <= 7 => 'advanced',
                default => 'expert'
            };

            $pipelineStates = ['new','interview','shortlisted','offer','rejected','hired'];
            $state = $pipelineStates[array_rand($pipelineStates)];

            $applicationDate = Carbon::now()->subDays(rand(1, 90));

            $candidates[] = [
                'first_name' => $first,
                'last_name' => $last,
                'email' => strtolower($first.'.'.$last.$i).'@gmail.com',
                'phone' => '05' . rand(10000000, 99999999),
                'location' => ['Algiers','Oran','Constantine','Blida'][rand(0,3)],
                'availability' => rand(0,1) ? 'immediate' : '1 month',
                'exp_years' => $exp,
                'cv' => 'cv_'.$i.'.pdf',
                'linkedIn' => rand(0,1) ? 'https://linkedin.com/in/'.$first.$last : null,
                'github' => rand(0,1) ? 'https://github.com/'.$first.$last : null,
                'portfolio_url' => rand(0,1) ? 'https://'.$first.$last.'.dev' : null,
                'recruitment_pipeline' => $state,
                'notation' => rand(5, 10),
                'salary' => $salary,
                'level' => $level,
                'application_date' => $applicationDate,
                'interview_date' => in_array($state, ['interview','shortlisted','offer','hired'])
                    ? $applicationDate->copy()->addDays(rand(2,10))
                    : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('candidates')->insert($candidates);

        $candidateIds = DB::table('candidates')->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | PIVOTS
        |--------------------------------------------------------------------------
        */
        $pivotSkills = [];
        foreach ($candidateIds as $cid) {
            foreach ($skillIds->random(rand(2, 5)) as $sid) {
                $pivotSkills[] = [
                    'candidate_id' => $cid,
                    'skill_id' => $sid,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        DB::table('candidate_skill')->insert($pivotSkills);

        $pivotProfiles = [];
        foreach ($candidateIds as $cid) {
            $pivotProfiles[] = [
                'candidate_id' => $cid,
                'profilecv_id' => $profileIds->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('candidate_profilecv')->insert($pivotProfiles);
    }
}