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

    // ------------------------------------------------------------------
    // Dates (single source of truth)
    // ------------------------------------------------------------------
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();

    // ------------------------------------------------------------------
    // Entrees
    // ------------------------------------------------------------------
    $totalentreeToday = (float) Entree::whereBetween('date', [
        $today->startOfDay(),
        $today->endOfDay()
    ])->sum('valeur');

    $totalentreeYesterday = (float) Entree::whereBetween('date', [
        $yesterday->startOfDay(),
        $yesterday->endOfDay()
    ])->sum('valeur');

    $percentageentree = null;
    if ($totalentreeYesterday > 0) {
        $percentageValue = round(
            (($totalentreeToday - $totalentreeYesterday) / $totalentreeYesterday) * 100,
            2
        );
        $percentageentree = ($percentageValue > 0 ? '+' : '') . $percentageValue;
    }

    // ------------------------------------------------------------------
    // Depenses
    // ------------------------------------------------------------------
    $totaldepenseToday = (float) Depense::whereBetween('date', [
        $today->startOfDay(),
        $today->endOfDay()
    ])->sum('valeur');

    $totaldepenseYesterday = (float) Depense::whereBetween('date', [
        $yesterday->startOfDay(),
        $yesterday->endOfDay()
    ])->sum('valeur');

    $percentagedepense = null;
    if ($totaldepenseYesterday > 0) {
        $percentageValue = round(
            (($totaldepenseToday - $totaldepenseYesterday) / $totaldepenseYesterday) * 100,
            2
        );
        $percentagedepense = ($percentageValue > 0 ? '+' : '') . $percentageValue;
    }

    // ------------------------------------------------------------------
    // Projects
    // ------------------------------------------------------------------
    $projects = Project::with('client')->paginate(5);

    // ------------------------------------------------------------------
    // Initial trésorerie
    // ------------------------------------------------------------------
    $firstEntree = Entree::orderBy('date')->first();

    if ($firstEntree && $firstEntree->note === 'initial') {
        $initial = (float) $firstEntree->valeur;
    } else {
        $initial = (float) Entree::where('date', '<=', $yesterday->endOfDay())->sum('valeur')
            - (float) Depense::where('date', '<=', $yesterday->endOfDay())->sum('valeur');
    }

    // ------------------------------------------------------------------
    // Finale trésorerie
    // ------------------------------------------------------------------
    $finale = (float) Entree::sum('valeur') - (float) Depense::sum('valeur');

    $percentageFinale = null;
    if ($initial != 0) {
        $value = round((($finale - $initial) / $initial) * 100, 2);
        $percentageFinale = ($value > 0 ? '+' : '') . $value;
    }

    // ------------------------------------------------------------------
    // Solde (today vs yesterday)
    // ------------------------------------------------------------------
    $solde = $totalentreeToday - $totaldepenseToday;
    $soldeYesterday = $totalentreeYesterday - $totaldepenseYesterday;

    $percentageSolde = null;
    if ($soldeYesterday != 0) {
        $value = round((($solde - $soldeYesterday) / $soldeYesterday) * 100, 2);
        $percentageSolde = ($value > 0 ? '+' : '') . $value;
    }

    // ------------------------------------------------------------------
    // Last 7 days dates
    // ------------------------------------------------------------------
    $last7Dates = collect(range(6, 0))->map(fn ($i) => Carbon::now()->subDays($i));
    $last7Days = $last7Dates->map(fn ($d) => $d->translatedFormat('l'))->toArray();
    $last7DateStrings = $last7Dates->map(fn ($d) => $d->toDateString());

    // ------------------------------------------------------------------
    // Weekly Entrees & Depenses (grouped by DATE, not day name)
    // ------------------------------------------------------------------
    $entreesWeek = Entree::where('date', '>=', Carbon::now()->subDays(6)->startOfDay())
        ->get(['date', 'valeur'])
        ->groupBy(fn ($item) => Carbon::parse($item->date)->toDateString())
        ->map->sum('valeur');

    $depensesWeek = Depense::where('date', '>=', Carbon::now()->subDays(6)->startOfDay())
        ->get(['date', 'valeur'])
        ->groupBy(fn ($item) => Carbon::parse($item->date)->toDateString())
        ->map->sum('valeur');

    $entreeValeurWeek = [];
    $depenseValeurWeek = [];
    $tresorerieValuerWeek = [];

    foreach ($last7DateStrings as $date) {
        $entreeValeurWeek[] = $entreesWeek[$date] ?? 0;
        $depenseValeurWeek[] = $depensesWeek[$date] ?? 0;

        $tresorerieValuerWeek[] =
            (float) Entree::where('date', '<=', $date)->sum('valeur')
            - (float) Depense::where('date', '<=', $date)->sum('valeur');
    }

    // ------------------------------------------------------------------
    return view('Dashboard', compact(
        'totalentreeToday',
        'percentageentree',
        'totaldepenseToday',
        'percentagedepense',
        'projects',
        'initial',
        'finale',
        'percentageFinale',
        'solde',
        'percentageSolde',
        'entreeValeurWeek',
        'depenseValeurWeek',
        'tresorerieValuerWeek',
        'last7Days'
    ));
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
