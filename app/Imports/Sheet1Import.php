<?php

namespace App\Imports;

use App\Models\Depense;
use App\Models\DepenseNom;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class Sheet1Import implements ToCollection
{
    /**
     * @param Collection $rows
     */
    

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

        foreach ($rows as $row) {

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

                // Parse start dates for columns 2-23
                for ($i = 2; $i <= 23; $i++) {
                    $cell = trim($row[$i] ?? '');
                    if ($cell && preg_match('/(\w+)\s+(\d+)-(\d+)/', $cell, $matches)) {
                        $monthName = trim($matches[1]); // clean spaces
                        $day = $matches[2]; // start day of period
                        if (isset($months[$monthName])) {
                            $startDates[$i] = Carbon::create(2026, $months[$monthName], $day);
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

            // Store DepenseNom and Depense rows
            if ($canStore) {
                dump($row);
                if (!empty($row[1])) {
                    $type = "fix"; // default
                    if (isset($row[0]) && $row[0] == "Variables") $type = "variable";

                    // Create or get DepenseNom
                    $depenseNom = DepenseNom::firstOrCreate(
                        ['nom' => $row[1]],
                        ['type' => $type]
                    );

                    // Create Depense rows
                    for ($i = 2; $i <= 23; $i++) {
                        $valeur = trim($row[$i] ?? '');
                        $date = $startDates[$i] ?? null;

                        if (is_numeric($valeur) && $valeur !== '' && $date) {
                            Depense::create([
                                'depense_noms_id' => $depenseNom->id,
                                'valeur' => $valeur,
                                'date' => $date,
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
