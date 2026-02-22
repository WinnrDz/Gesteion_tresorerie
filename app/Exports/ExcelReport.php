<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\User;
use App\Models\Depense;
use Carbon\Carbon;

class ExcelReport
{
    public function download()
    {
        $templatePath = storage_path('app/excel/template.xlsx');
        $spreadsheet = IOFactory::load($templatePath);

        // --- Sheet 1: Users ---
        $depenseSheet = $spreadsheet->getSheetByName('Prévisions Dépenses-Décaiss'); // Sheet name must match exactly
        $depenses = Depense::whereYear('date', Carbon::now()->year)->get();


        $startRow = 26;
        $endRow   = 200; // or large enough to cover all tables
        $startCol = 'C';
        $currentHeaderRow = 25; // default starting header

        for ($row = $startRow; $row <= $endRow; $row++) {
            $depenseName = $depenseSheet->getCell('B' . $row)->getValue();

            // Check if this row is a new header row (column C contains a day-range like 1-7)
            $firstPeriodCell = $depenseSheet->getCell($startCol . $row)->getValue();
            if (!empty($firstPeriodCell) && preg_match('/\d+-\d+/', $firstPeriodCell)) {
                $currentHeaderRow = $row;
                continue; // skip the header row itself
            }

            // Skip rows without a depense name
            if (empty($depenseName)) continue;

            // Loop through columns of the current table
            $highestCol = $depenseSheet->getHighestColumn();
            for ($col = $startCol; $col <= $highestCol; $col++) {
                $dateHeader = $depenseSheet->getCell($col . $currentHeaderRow)->getValue();
                if (empty($dateHeader)) continue;

                if (preg_match('/(\d+)-(\d+)/', $dateHeader, $matches)) {
                    $startDay = (int)$matches[1];
                    $endDay   = (int)$matches[2];

                    // Map French month
                    $months = [
                        'Janvier' => 1,
                        'Fevrier' => 2,
                        'Mars' => 3,
                        'Avril' => 4,
                        'Mai' => 5,
                        'Juin' => 6,
                        'Juillet' => 7,
                        'Aout' => 8,
                        'Septembre' => 9,
                        'Octobre' => 10,
                        'Novembre' => 11,
                        'Decembre' => 12
                    ];

                    foreach ($months as $name => $num) {
                        if (str_contains($dateHeader, $name)) {
                            $monthNum = $num;
                            break;
                        }
                    }

                    $year = Carbon::now()->year;

                    $startDate = Carbon::create($year, $monthNum, $startDay)->startOfDay();
                    $endDate   = Carbon::create($year, $monthNum, $endDay)->endOfDay();

                    $total = Depense::whereHas('depenseNom', function ($query) use ($depenseName) {
                        $query->where('nom', $depenseName);
                    })
                        ->whereBetween('date', [$startDate, $endDate])
                        ->sum('valeur');

                    $depenseSheet->setCellValue($col . $row, $total);
                }
            }
        }


        // Save to temporary file and return download
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $fileName = 'report.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}
