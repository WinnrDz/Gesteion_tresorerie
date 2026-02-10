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
    public function index(Request $request)
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
        $totalentreeToday = (float) Entree::whereDate('date', today())->sum('valeur');


        $totalentreeYesterday = (float) Entree::whereDate('date', $yesterday)
            ->sum('valeur');


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
        $totaldepenseToday = (float) Depense::whereDate('date', today())
            ->sum('valeur');

        $totaldepenseYesterday = (float) Depense::whereDate('date', $yesterday)
            ->sum('valeur');


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

        //---------------------------------------------------------
        //set fake date
        //---------------------------------------------------------------

        if ($request->has('week')) {
            $week = request('week');
            [$year, $weekNumber] = explode('-W', $week);


            $fakeNow = Carbon::now()
                ->setISODate($year, $weekNumber)
                ->endOfWeek();


            Carbon::setTestNow($fakeNow);
        }


        if ($request->has('month')) {
            $month = $request->month; // "2026-02"

            // Split year and month
            [$year, $monthNumber] = explode('-', $month);

            // Get last day of the month
            $lastDayOfMonth = Carbon::create($year, $monthNumber, 1)
                ->endOfMonth();

            // Trick Carbon::now() if needed
            Carbon::setTestNow($lastDayOfMonth);
        }


        if ($request->has('year')) {
            $year = $request->year ?? date('Y'); // fallback to current year if not selected

            // Get last day of the year
            $lastDayOfYear = Carbon::create($year, 1, 1)  // first day of year
                ->endOfYear();                             // last day of year

            // Trick Carbon::now()
            Carbon::setTestNow($lastDayOfYear);
        }

        //dd(Carbon::now());









        // ------------------------------------------------------------------
        // Last 7 days dates
        // ------------------------------------------------------------------
        $last7Dates = collect(range(6, 0))->map(fn($i) => Carbon::now()->subDays($i));
        $last7Days = $last7Dates->map(fn($d) => $d->translatedFormat('l'))->toArray();
        $last7DateStrings = $last7Dates->map(fn($d) => $d->toDateString());


        // ------------------------------------------------------------------
        // Last 4 weeks (oldest → current week)
        // ------------------------------------------------------------------
        $last4Weeks = collect(range(3, 0))->map(fn($i) => Carbon::now()->subWeeks($i));

        // Generate start-end date labels for each week
        $weekLabels = $last4Weeks->map(
            fn($d) =>
            $d->startOfWeek()->format('d M') . ' - ' . $d->endOfWeek()->format('d M')
        )->toArray();

        // ------------------------------------------------------------------
        // Last 4 weeks dates
        // ------------------------------------------------------------------
        $last4Weeks = collect(range(3, 0))->map(fn($i) => Carbon::now()->subWeeks($i));
        $last4WeekLabels = $last4Weeks->map(
            fn($d) =>
            $d->startOfWeek()->toDateString() . ' - ' . $d->endOfWeek()->toDateString()
        )->toArray();

        // ------------------------------------------------------------------
        // Weekly Entrees & Depenses (last 4 weeks, grouped by week range)
        // ------------------------------------------------------------------
        $entreesLast4Weeks = $last4Weeks->mapWithKeys(function ($week) {
            $start = $week->copy()->startOfWeek()->startOfDay();
            $end = $week->copy()->endOfWeek()->endOfDay();

            $total = Entree::whereBetween('date', [$start, $end])->sum('valeur');
            return [$week->startOfWeek()->toDateString() . ' - ' . $week->endOfWeek()->toDateString() => $total];
        });

        $depensesLast4Weeks = $last4Weeks->mapWithKeys(function ($week) {
            $start = $week->copy()->startOfWeek()->startOfDay();
            $end = $week->copy()->endOfWeek()->endOfDay();

            $total = Depense::whereBetween('date', [$start, $end])->sum('valeur');
            return [$week->startOfWeek()->toDateString() . ' - ' . $week->endOfWeek()->toDateString() => $total];
        });

        // Prepare arrays for chart
        $entreeValeurLast4Weeks = [];
        $depenseValeurLast4Weeks = [];
        $tresorerieValeurLast4Weeks = [];

        foreach ($last4WeekLabels as $weekRange) {
            [$start, $end] = explode(' - ', $weekRange);

            $entreeValeurLast4Weeks[] = $entreesLast4Weeks[$weekRange] ?? 0;
            $depenseValeurLast4Weeks[] = $depensesLast4Weeks[$weekRange] ?? 0;

            $tresorerieValeurLast4Weeks[] =
                (float) Entree::where('date', '<=', $end)->sum('valeur')
                - (float) Depense::where('date', '<=', $end)->sum('valeur');
        }


        // ------------------------------------------------------------------
        // Weekly Entrees & Depenses (grouped by DATE, not day name)
        // ------------------------------------------------------------------
        $entreesWeek = Entree::where('date', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->get(['date', 'valeur'])
            ->groupBy(fn($item) => Carbon::parse($item->date)->toDateString())
            ->map->sum('valeur');

        $depensesWeek = Depense::where('date', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->get(['date', 'valeur'])
            ->groupBy(fn($item) => Carbon::parse($item->date)->toDateString())
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
        // Last N months (dynamic)
        // ------------------------------------------------------------------
        $lastMonthsCount = 12; // change this number as needed
        $lastMonths = collect(range($lastMonthsCount - 1, 0))->map(fn($i) => Carbon::now()->subMonths($i));

        // Labels (month names only)
        $lastMonthLabels = $lastMonths->map(
            fn($month) =>
            $month->translatedFormat('F') // "Janvier", "Février", etc.
        )->toArray();

        // ------------------------------------------------------------------
        // Monthly Entrees & Depenses (last N months, grouped by month)
        // ------------------------------------------------------------------
        $entreesLastMonths = $lastMonths->mapWithKeys(function ($month) {
            $start = $month->copy()->startOfMonth()->startOfDay();
            $end = $month->copy()->endOfMonth()->endOfDay();

            $total = Entree::whereBetween('date', [$start, $end])->sum('valeur');
            return [$month->month => $total]; // use month number as key
        });

        $depensesLastMonths = $lastMonths->mapWithKeys(function ($month) {
            $start = $month->copy()->startOfMonth()->startOfDay();
            $end = $month->copy()->endOfMonth()->endOfDay();

            $total = Depense::whereBetween('date', [$start, $end])->sum('valeur');
            return [$month->month => $total]; // use month number as key
        });

        // Prepare arrays for chart
        $entreeValeurLastMonths = [];
        $depenseValeurLastMonths = [];
        $tresorerieValeurLastMonths = [];

        foreach ($lastMonths as $month) {
            $monthNumber = $month->month;
            $monthEnd = $month->copy()->endOfMonth()->endOfDay();

            $entreeValeurLastMonths[] = $entreesLastMonths[$monthNumber] ?? 0;
            $depenseValeurLastMonths[] = $depensesLastMonths[$monthNumber] ?? 0;

            $tresorerieValeurLastMonths[] =
                (float) Entree::where('date', '<=', $monthEnd)->sum('valeur')
                - (float) Depense::where('date', '<=', $monthEnd)->sum('valeur');
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
            'last7Days',
            'weekLabels',
            'entreeValeurLast4Weeks',
            'depenseValeurLast4Weeks',
            'tresorerieValeurLast4Weeks',
            'lastMonthLabels',
            'entreeValeurLastMonths',
            'depenseValeurLastMonths',
            'tresorerieValeurLastMonths',
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
