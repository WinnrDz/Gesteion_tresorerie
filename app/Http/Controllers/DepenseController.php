<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Depense;
use App\Models\Fixes;
use App\Models\Mois;
use App\Models\Periode;
use App\Models\Variables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('depenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "date" => '',
            "periode_type" => '',

            "salaire_net" => '',
            "irg" => '',
            "secu_35" => '',
            "abon_tel" => '',
            "loyer" => '',

            "g50_tap" => '',
            "g50_tva" => '',
            "g50_acompte_ibs" => '',
            "achats_materiels" => '',
            "autres" => ''            
        ]);


        $depenses = Depense::all();

        foreach ($depenses as $depense) {

            // check if in same week
            if ($depense->periode_type == "semaine"){
                $reqdate = $validated["date"];
    
                $reqdateCarbon = Carbon::parse($reqdate);
    
                    $depenseDate = Carbon::parse($depense->date);
    
                    if (
                        $reqdateCarbon->month == $depenseDate->month &&     
                        $reqdateCarbon->year == $depenseDate->year &&        
                        $reqdateCarbon->weekOfMonth == $depenseDate->weekOfMonth  
                    ) {
                        dd("This week is already created");
                    }
                }

        }
        
        DB::transaction(function() use ($validated) 
        {
        $date = $validated["date"];
        
        

        $fixes = Fixes::create([
            "salaire_net" => $validated["salaire_net"],
            "irg" => $validated["irg"],
            "secu_35" => $validated["secu_35"],
            "abon_tel" => $validated["abon_tel"],
            "loyer" => $validated["loyer"],
        ]);

        $variables = Variables::create([
            "g50_tap" => $validated["g50_tap"],
            "g50_tva" => $validated["g50_tva"],
            "g50_acompte_ibs" => $validated["g50_acompte_ibs"],
            "achats_materiels" => $validated["achats_materiels"],
            "autres" => $validated["autres"]
        ]);

        Depense::create([
            "fixes_id" => $fixes->id,
            "variables_id" => $variables->id,
            "date" => $validated["date"],
            "periode_type" => $validated["periode_type"]
        ]);
        });

        



    }

    /**
     * Display the specified resource.
     */
    public function show(Depense $depense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depense $depense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Depense $depense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depense $depense)
    {
        //
    }
}
