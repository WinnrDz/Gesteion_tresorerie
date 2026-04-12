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
                'name' => 'User',
                'email' => 'user@test.com',
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
        $clients = [];
        for ($i = 1; $i <= 5; $i++) {
            $clients[] = [
                'nom' => "Client $i",
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
        $projects = [];
        for ($i = 1; $i <= 10; $i++) {
            $projects[] = [
                'nom' => "Project $i",
                'montant' => rand(1000, 10000),
                'client_id' => $clientIds->random(),
                'created_at' => now(),
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
            ['nom' => 'Rent', 'type' => 'fix', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Salary', 'type' => 'fix', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Marketing', 'type' => 'variable', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $depenseNomIds = DB::table('depense_noms')->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | DEPENSES
        |--------------------------------------------------------------------------
        */
        $depenses = [];
        for ($i = 1; $i <= 20; $i++) {
            $depenses[] = [
                'valeur' => rand(100, 5000),
                'date' => Carbon::now()->subDays(rand(1, 100)),
                'note' => "Expense $i",
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
        | ENTREES
        |--------------------------------------------------------------------------
        */
        $entrees = [];
        for ($i = 1; $i <= 20; $i++) {
            $entrees[] = [
                'valeur' => rand(500, 10000),
                'date' => Carbon::now()->subDays(rand(1, 100)),
                'type' => rand(0, 1) ? 'project' : 'autre',
                'note' => "Income $i",
                'attachment' => null,
                'attachment_name' => null,
                'project_id' => $projectIds->random(),
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
        $skills = ['Laravel', 'React', 'Vue', 'PHP', 'MySQL', 'JavaScript', 'NodeJS'];
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
            'Frontend Developer',
            'Backend Developer',
            'Fullstack Developer',
            'DevOps Engineer',
            'UI/UX Designer'
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
        | CANDIDATES (NO DUPLICATES)
        |--------------------------------------------------------------------------
        */
        $firstNames = [
            'Mohamed','Youssef','Amine','Rania','Sara','Omar','Yasmine','Karim','Nassim','Lina',
            'Adam','Hassan','Imane','Khalil','Amina','Bilal','Salma','Nour','Reda','Zineb',
            'Walid','Fatima','Tarek','Asma','Ilyes','Sofiane','Chiraz','Anis','Meriem','Ayoub'
        ];

        $lastNames = [
            'Ali','Benali','Kaci','Meziane','Bennani','Haddad','Cherif','Bouaziz','Farhi','Mokhtar',
            'Hassan','Zerrouki','Belaid','Hamdi','Saidi','Khelifi','Amrani','Boudiaf','Larbi','Djaafar',
            'Bensaid','Touati','Rebbah','Guerfi','Mansouri','Bougherra','Derradji','Belkacem','Ouahab','Khellaf'
        ];

        $used = [];
        $candidates = [];

        for ($i = 0; $i < 30; $i++) {

            do {
                $first = $firstNames[array_rand($firstNames)];
                $last = $lastNames[array_rand($lastNames)];
                $full = $first . ' ' . $last;
            } while (in_array($full, $used));

            $used[] = $full;

            $candidates[] = [
                'first_name' => $first,
                'last_name' => $last,
                'email' => strtolower(str_replace(' ', '', $full)) . $i . '@test.com',
                'phone' => '07' . rand(10000000, 99999999),
                'location' => 'City ' . rand(1, 10),
                'availability' => 'immediate',
                'exp_years' => rand(0, 10),
                'cv' => 'cv.pdf',
                'linkedIn' => null,
                'github' => null,
                'portfolio_url' => null,
                'recruitment_pipeline' => ['new','interview','shortlisted','offer','rejected','hired'][rand(0,5)],
                'notation' => rand(1, 10),
                'salary' => rand(500, 5000),
                'level' => ['beginner','intermediate','advanced','expert'][rand(0,3)],
                'application_date' => now()->subDays(rand(1, 60)),
                'interview_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('candidates')->insert($candidates);

        $candidateIds = DB::table('candidates')->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | PIVOT: candidate_skill
        |--------------------------------------------------------------------------
        */
        $pivotSkills = [];
        foreach ($candidateIds as $cid) {
            foreach ($skillIds->random(rand(2, 4)) as $sid) {
                $pivotSkills[] = [
                    'candidate_id' => $cid,
                    'skill_id' => $sid,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        DB::table('candidate_skill')->insert($pivotSkills);

        /*
        |--------------------------------------------------------------------------
        | PIVOT: candidate_profilecv
        |--------------------------------------------------------------------------
        */
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