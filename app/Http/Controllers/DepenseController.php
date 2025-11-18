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


        // validate the date
        

        $validatedDate = $request->validate([
            "date" => '',
            "periode_type" => '',
       
        ]);


        $depenses = Depense::all();

        foreach ($depenses as $depense) {

            // check if in same week
            if ($depense->periode_type == "semaine"){
                $reqdate = $validatedDate["date"];
    
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


        // validate the fixes and variables
        
        //dd($request->all());

        $reqarray = $request->all();

        $array_keys = array_keys($reqarray);

        for ($i = 3; $i < count($array_keys); $i++) {
            //dd($array_keys[$i]);
            
        }



        foreach ($request->all() as $key => $value) {
            
        };

        



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
