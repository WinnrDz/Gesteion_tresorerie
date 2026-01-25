<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetImport implements WithMultipleSheets
{
    
    public function sheets(): array
    {
      return [
            0 => new Sheet1Import(),
            1 => new Sheet2Import(),
            2 => new Sheet3Import(),
        ];
    }
}
