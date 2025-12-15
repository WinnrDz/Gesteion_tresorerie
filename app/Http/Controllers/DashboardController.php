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
            $percentageentree = null;
        } else {
            $percentageentree = round((($totalentreeToday - $totalentreeYesterday) * 100) / $totalentreeYesterday, 2);
        }

        if ($percentageentree > 0) {
            $percentageentree = "+" . $percentageentree;
        }

        //-------------------------------------------------------------------------------------------------------------------------------


        $totaldepenseToday = Depense::whereDate('date', now())->sum('valeur');

        $yesterday = Carbon::yesterday();
        $totaldepenseYesterday = Depense::whereDate('date', $yesterday)->sum('valeur');

        if ($totaldepenseYesterday == 0) {
            $percentagedepense = null;
        } else {
            $percentagedepense = round((($totaldepenseToday - $totaldepenseYesterday) * 100) / $totaldepenseYesterday, 2);
        }

        if ($percentagedepense > 0) {
            $percentagedepense = "+" . $percentagedepense;
        }

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

        if ($initial != 0) {
            $percentageFinale = round(($finale - $initial) / ($initial) * 100);
        } else {
            $percentageFinale = null;
        }
        if ($percentageFinale > 0) {
            $percentageFinale = "+" . $percentageFinale;
        }

        //-------------------------------------------------------------------------------------------------------------------------------

        $solde = $totalentreeToday - $totaldepenseToday;

        $soldeYesterday = $totalentreeYesterday - $totaldepenseYesterday;

        if ($soldeYesterday != 0) {
            $percentageSolde = ($solde - $soldeYesterday) / $soldeYesterday * 100;
        } else {
            $percentageSolde = null;
        }

        if ($percentageSolde > 0) {
            $percentageSolde = "+" . $percentageSolde;
        }

        //-------------------------------------------------------------------------------------------------------------------------------

        $entreeDateValeurWeek = Entree::where('date', '>=', Carbon::now()->subDays(7))
            ->get(['date', 'valeur']) 
            ->mapWithKeys(function ($item) {
                $dayName = Carbon::parse($item->date)->format('l'); 
                return [$dayName => $item->valeur];
            })
            ->toArray();


        $last7Days = [];

        for ($i = 6; $i >= 0; $i--) {
            $last7Days[] = Carbon::now()->subDays($i)->format('l');
        }

        $entreeValeurWeek = [0,0,0,0,0,0,0];

        foreach ($last7Days as $key => $v) {
            if (isset($entreeDateValeurWeek[$v])) $entreeValeurWeek[$key] = $entreeDateValeurWeek[$v];
        }

        //dd($entreeValeurWeek);
        //dd($Last7Days);

        $last7Days = array_map(fn($last7Days) => $last7Days[0], $last7Days);

        //-------------------------------------------------------------------------------------------------------------------------------


        return view('Dashboard', compact("totalentreeToday", "percentageentree", "totaldepenseToday", "percentagedepense", "projects", "initial", "finale", "percentageFinale", "solde", "percentageSolde","entreeValeurWeek","last7Days"));
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
