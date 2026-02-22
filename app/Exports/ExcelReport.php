<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Depense;
use App\Models\Entree;
use Carbon\Carbon;

class ExcelReport
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year; // store user-provided year
    }

    public function download()
    {
        $templatePath = storage_path('app/excel/template.xlsx');
        $spreadsheet = IOFactory::load($templatePath);

        // --- Sheet 1: Dépenses ---
        $depenseSheet = $spreadsheet->getSheetByName('Prévisions Dépenses-Décaiss');

        $startRow = 26;
        $endRow   = 200;
        $startCol = 'C';
        $currentHeaderRow = 25;

        for ($row = $startRow; $row <= $endRow; $row++) {
            $depenseName = $depenseSheet->getCell('B' . $row)->getValue();

            $firstPeriodCell = $depenseSheet->getCell($startCol . $row)->getValue();
            if (!empty($firstPeriodCell) && preg_match('/\d+-\d+/', $firstPeriodCell)) {
                $currentHeaderRow = $row;
                continue;
            }

            if (empty($depenseName)) continue;

            $highestCol = $depenseSheet->getHighestColumn();
            for ($col = $startCol; $col <= $highestCol; $col++) {
                $dateHeader = $depenseSheet->getCell($col . $currentHeaderRow)->getValue();
                if (empty($dateHeader)) continue;

                if (preg_match('/(\d+)-(\d+)/', $dateHeader, $matches)) {
                    $startDay = (int)$matches[1];
                    $endDay   = (int)$matches[2];

                    $months = [
                        'Janvier' => 1, 'Fevrier' => 2, 'Mars' => 3,
                        'Avril' => 4, 'Mai' => 5, 'Juin' => 6,
                        'Juillet' => 7, 'Aout' => 8, 'Septembre' => 9,
                        'Octobre' => 10, 'Novembre' => 11, 'Decembre' => 12
                    ];

                    foreach ($months as $name => $num) {
                        if (str_contains($dateHeader, $name)) {
                            $monthNum = $num;
                            break;
                        }
                    }

                    $startDate = Carbon::create($this->year, $monthNum, $startDay)->startOfDay();
                    $endDate   = Carbon::create($this->year, $monthNum, $endDay)->endOfDay();

                    $total = Depense::whereHas('depenseNom', function ($query) use ($depenseName) {
                        $query->where('nom', $depenseName);
                    })
                        ->whereBetween('date', [$startDate, $endDate])
                        ->sum('valeur');

                    $depenseSheet->setCellValue($col . $row, $total);
                }
            }
        }

        // --- Sheet 2: Entrées ---
        $entreeSheet = $spreadsheet->getSheetByName('Prévisions Entrées-Encaiss');

        $startRow = 20;
        $endRow   = 90;
        $startCol = 'C';
        $currentHeaderRow = 25;

        for ($row = $startRow; $row <= $endRow; $row++) {

            $clientName = $entreeSheet->getCell('B' . $row)->getValue();
            $firstPeriodCell = $entreeSheet->getCell($startCol . $row)->getValue();

            if (!empty($firstPeriodCell) && preg_match('/\d+-\d+/', $firstPeriodCell)) {
                $currentHeaderRow = $row;
                continue;
            }

            if (empty($clientName)) continue;

            $highestCol = $entreeSheet->getHighestColumn();

            for ($col = $startCol; $col <= $highestCol; $col++) {
                $dateHeader = $entreeSheet->getCell($col . $currentHeaderRow)->getValue();
                if (empty($dateHeader)) continue;

                if (preg_match('/(\d+)-(\d+)/', $dateHeader, $matches)) {
                    $startDay = (int)$matches[1];
                    $endDay   = (int)$matches[2];

                    $months = [
                        'Janvier' => 1, 'Fevrier' => 2, 'Mars' => 3,
                        'Avril' => 4, 'Mai' => 5, 'Juin' => 6,
                        'Juillet' => 7, 'Aout' => 8, 'Septembre' => 9,
                        'Octobre' => 10, 'Novembre' => 11, 'Decembre' => 12
                    ];

                    foreach ($months as $name => $num) {
                        if (str_contains($dateHeader, $name)) {
                            $monthNum = $num;
                            break;
                        }
                    }

                    $startDate = Carbon::create($this->year, $monthNum, $startDay)->startOfDay();
                    $endDate   = Carbon::create($this->year, $monthNum, $endDay)->endOfDay();

                    $total = Entree::whereHas('project.client', function ($query) use ($clientName) {
                        $query->where('nom', $clientName);
                    })
                        ->whereBetween('date', [$startDate, $endDate])
                        ->sum('valeur');

                    $entreeSheet->setCellValue($col . $row, $total);
                }
            }
        }

        // Save and download
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $fileName = 'report.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}