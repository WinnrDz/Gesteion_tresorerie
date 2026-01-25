<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\MultiSheetImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function showForm()
    {
        return view('excel.upload');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new MultiSheetImport, $request->file('file'));

        return back()->with('success', 'File imported! Check dd() output.');
    }
}
