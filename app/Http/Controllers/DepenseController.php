<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Depense;
use App\Models\Fixes;
use App\Models\Mois;
use App\Models\Periode;
use App\Models\Variables;
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
            "annee" => "required",
            "mois" => "required",
            "periode" => "required",

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
        
        DB::transaction(function() use ($validated) 
        {
            
        $annee = Annee::create([
            'annee' => $validated["annee"],
            'total_depense_annee' => null,
            'total_entree_annee' => null
        ]);

        $mois = Mois::create([
            'mois' => $validated["mois"],
            'annee_id' => $annee->id,
            'total_depense_mois' => null,
            'total_entree_mois' => null
        ]);

        $periode = Periode::create([
            "periode" => $validated["periode"],
            "mois_id" => $mois->id,
            'total_depense_periode' => null,
            'total_entree_periode' => null
        ]);

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
            "periode_id" => $periode->id
        ]);

        //calculer les total

        $totalDepense = $fixes->salaire_net + $fixes->irg + $fixes->secu_35 + $fixes->abon_tel + $fixes->loyer
                + $variables->g50_tap + $variables->g50_tva + $variables->g50_acompte_ibs
                + $variables->achats_materiels + $variables->autres;

        Depense::where('periode_id', $periode->id)->update(['total_depense' => $totalDepense]);


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
