<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Entree;
use App\Models\Project;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class Sheet2Import implements ToCollection
{
    /**
     * @param Collection $rows
     */

    protected int $year;

    public function __construct(int $year)
    {
        $this->year = $year;
    }

    
    public function collection(Collection $rows)
    {
        $periodesRow = null;
        $totalRow = null;
        $canStore = false;
        $startDates = [];

        $months = [
            'Janvier' => 1, 'Fevrier' => 2, 'Mars' => 3,
            'Avril' => 4, 'Mai' => 5, 'Juin' => 6,
            'Juillet' => 7, 'Aout' => 8, 'Septembre' => 9,
            'Octobre' => 10, 'Novembre' => 11, 'Decembre' => 12
        ];

        foreach ($rows as $index => $row) {
            if ($index == 92) break;
            // Clean row cells
            $row = $row->map(fn ($cell) => is_string($cell) ? trim($cell) : $cell);

            $isEmpty = $row->filter()->isEmpty();

            if ($periodesRow == null && $totalRow == null && !$isEmpty) {
                $canStore = true;
            }

            // Detect periods row
            if (isset($row[0]) && str_starts_with($row[0], 'Elements')) {
                dump($row);
                $periodesRow = $row;
                $canStore = false;

                // Parse start dates for columns 2-24
                for ($i = 2; $i <= 24; $i++) {
                    $cell = trim($row[$i] ?? '');
                    if ($cell && preg_match('/(\w+)\s+(\d+)-(\d+)/', $cell, $matches)) {
                        $monthName = trim($matches[1]); // clean spaces
                        $day = $matches[2]; // start day of period
                        if (isset($months[$monthName])) {
                            $startDates[$i] = Carbon::create($this->year, $months[$monthName], $day);
                        } else {
                            $startDates[$i] = null;
                        }
                    } else {
                        $startDates[$i] = null;
                    }
                }
            }

            // Detect total row
            if (isset($row[0]) && str_starts_with($row[0], 'Total')) {
                $totalRow = $row;
                $canStore = false;
            }

            // Store Entree rows
            if ($canStore) {
                dump($row);
                $type = "project"; // default
                if (!empty($row[1])) {


                    // Create or get Client
                    $client = Client::firstOrCreate(
                        ['nom' => $row[1]],

                    );

                    // Create or get Project
                    $project = Project::firstOrCreate(
                        ['nom' => "projects from client " . $client->nom],
                        [
                            'client_id' => $client->id,
                            'montant' => '0'
                        ],
                    );

                    // Create Entree rows
                    for ($i = 2; $i <= 23; $i++) {
                        $valeur = trim($row[$i] ?? '');
                        $date = $startDates[$i] ?? null;

                        if (is_numeric($valeur) && $valeur !== '' && $date) {
                            Entree::create([
                                'project_id' => $project->id,
                                'valeur' => $valeur,
                                'date' => $date,
                                'type' => $type,
                            ]);
                        }
                    }
                }

                if (isset($row[0]) && str_starts_with($row[0], 'Autres')) {
                    $type = "autre";
                    for ($i = 2; $i <= 23; $i++) {
                        $valeur = trim($row[$i] ?? '');
                        $date = $startDates[$i] ?? null;

                        if (is_numeric($valeur) && $valeur !== '' && $date) {
                            Entree::create([
                                'valeur' => $valeur,
                                'date' => $date,
                                'type' => $type,
                            ]);
                        }
                    }
                }
            }


            // Reset flags
            if ($totalRow != null) $totalRow = null;
            if ($periodesRow != null) $periodesRow = null;
            if ($canStore == true) $canStore = false;
        }

        //dd('done');
    }
}
