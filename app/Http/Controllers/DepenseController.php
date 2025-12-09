<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Depense;
use App\Models\depensenom;
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
    
        $depenses = Depense::with("depenseNom")->get();
    
        return view("depenses.index", compact("depenses"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $depensenoms = depensenom::all();
        return view('depenses.create', compact("depensenoms"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $validated = $request->validate([
            "valeur" => "required",
            "date" => "required",
            "note" => "",
            "attachment" => "",
            "depensenom_id" => "required"
        ]);


        
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $validated['attachment'] = file_get_contents($file->getRealPath());
            $validated['attachment_name'] = $file->getClientOriginalName();
        } else {
            $validated['attachment'] = null;
        }

        Depense::create($validated);

        return redirect()->route('depenses.index')->with('success', 'Depense created successfully!');


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
    
    public function download($id) {

        $depense = Depense::find($id);

        if (!$depense->attachment || !$depense->attachment_name) {
            return redirect()->back()->with('error', 'No attachment found.');
        }

        $filename = $depense->attachment_name;

        return response($depense->attachment)
        ->header('Content-Type','application/octet-stream')
        ->header('Content-Disposition', 'attachment; filename="' . $filename);

    }
}
