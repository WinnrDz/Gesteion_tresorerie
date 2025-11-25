<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Models\Entree;

use function Symfony\Component\Clock\now;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalentreeToday = Entree::whereDate('date', now())->sum('valeur');

        $yesterday = Carbon::yesterday();
        $totalentreeYesterday = Entree::whereDate('date', $yesterday)->sum('valeur');

        if ($totalentreeYesterday == 0) {
            $percentageentree = 100; 
        } else {
            $percentageentree = round((($totalentreeToday - $totalentreeYesterday) * 100) / $totalentreeYesterday, 2); 
        }

        if ($percentageentree > 0 ) { $percentageentree = "+" . $percentageentree;} 
        
        return view('Dashboard', compact("totalentreeToday", "percentageentree"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
