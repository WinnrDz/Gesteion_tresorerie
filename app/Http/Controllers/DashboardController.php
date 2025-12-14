<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Models\Entree;
use App\Models\Project;

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

        //-------------------------------------------------------------------------------------------------------------------------------


        $totaldepenseToday = Depense::whereDate('date', now())->sum('valeur');

        $yesterday = Carbon::yesterday();
        $totaldepenseYesterday = Depense::whereDate('date', $yesterday)->sum('valeur');

        if ($totaldepenseYesterday == 0) {
            $percentagedepense = 100; 
        } else {
            $percentagedepense = round((($totaldepenseToday - $totaldepenseYesterday) * 100) / $totaldepenseYesterday, 2); 
        }

        if ($percentagedepense > 0 ) { $percentagedepense = "+" . $percentagedepense;} 

        //-------------------------------------------------------------------------------------------------------------------------------

        $projects = Project::with("client")->get();

        //-------------------------------------------------------------------------------------------------------------------------------
        $yesterday = Carbon::yesterday()->toDateString();

        if (Entree::exists()) {
            $initial = Entree::whereDate('date', '<=', $yesterday)->sum('valeur') - Depense::whereDate('date', '<=', $yesterday)->sum('valeur');
            //dd($initial);
        } else {
            $initial = null;
        }

        if (Entree::count() === 1 && Entree::first()->note === "initial") {
            $initial = Entree::first()->valeur;
        }
        
        //-------------------------------------------------------------------------------------------------------------------------------

        $finale = Entree::sum('valeur') - Depense::sum('valeur');

        if ($totalentreeYesterday - $totaldepenseYesterday != 0) {  
        $percentageFinale = round($finale / ($totalentreeYesterday - $totaldepenseYesterday) * 100);
        } else {
            $percentageFinale = 0;
        }
        if ($percentageFinale > 0 ) { $percentageFinale = "+" . $percentageFinale;} 

        return view('Dashboard', compact("totalentreeToday", "percentageentree", "totaldepenseToday", "percentagedepense", "projects","initial","finale","percentageFinale"));
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
