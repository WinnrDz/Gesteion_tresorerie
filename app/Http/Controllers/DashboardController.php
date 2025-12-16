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
        Carbon::setLocale('fr');

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

        $projects = Project::with("client")->paginate(5);

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

        function tresorerieDay($day)
        {
            return Entree::whereDate('date', '<=', $day)->sum('valeur') - Depense::whereDate('date', '<=', $day)->sum('valeur');
        }

        //dd(tresorerieDay("2025-12-14"));

        //-------------------------------------------------------------------------------------------------------------------------------
        $entreeDateValeurWeek = Entree::where('date', '>=', Carbon::now()->subDays(7))
            ->get(['date', 'valeur'])
            ->mapWithKeys(function ($item) {
                $dayName = Carbon::parse($item->date)->translatedFormat('l');
                return [$dayName => $item->valeur];
            })
            ->toArray();

        $depenseDateValeurWeek = Depense::where('date', '>=', Carbon::now()->subDays(7))
            ->get(['date', 'valeur'])
            ->mapWithKeys(function ($item) {
                $dayName = Carbon::parse($item->date)->translatedFormat('l');
                return [$dayName => $item->valeur];
            })
            ->toArray();


        $last7Days = [];
        $last7Dates = [];

        for ($i = 6; $i >= 0; $i--) {
            $last7Days[] = Carbon::now()->subDays($i)->translatedFormat('l');
            $last7Dates[] = Carbon::now()->subDays($i)->toDateString();
        }

        //dd($last7Dates);

        $entreeValeurWeek = [0, 0, 0, 0, 0, 0, 0];
        $depenseValeurWeek = [0, 0, 0, 0, 0, 0, 0];
        $tresorerieValuerWeek = [0, 0, 0, 0, 0, 0, 0];

        foreach ($last7Days as $key => $v) {
            if (isset($entreeDateValeurWeek[$v])) $entreeValeurWeek[$key] = $entreeDateValeurWeek[$v];
            if (isset($depenseDateValeurWeek[$v])) $depenseValeurWeek[$key] = $depenseDateValeurWeek[$v];
        }

        foreach($last7Dates as $key => $v) {
            $tresorerieValuerWeek[$key] = tresorerieDay($v);
        }


        //$last7Days = array_map(fn($last7Days) => $last7Days[0], $last7Days); from Dimanche to D

        //dd($entreeValeurWeek);
        //dd($depenseValeurWeek);
        //dd($tresorerieValuerWeek)
        //dd($last7Days);

        //-------------------------------------------------------------------------------------------------------------------------------




        return view('Dashboard', compact("totalentreeToday", "percentageentree", "totaldepenseToday", "percentagedepense", "projects", "initial", "finale", "percentageFinale", "solde", "percentageSolde", "entreeValeurWeek", "last7Days", "depenseValeurWeek","tresorerieValuerWeek"));
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
