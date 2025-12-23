<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Depense;
use App\Models\DepenseNom;
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
    public function index(Request $request)
    {
        $sortDate = $request->get('sort', 'desc');
        $sortNom  = $request->get('sortNom');
        $sortDeca  = $request->get('sortDeca');
        $search = $request->get('search');

        $query = Depense::with('DepenseNom');

        if ($sortNom) {
            $query->join('depense_noms', 'depenses.depense_noms_id', '=', 'depense_noms.id')
                ->orderBy('depense_noms.nom', $sortNom)
                ->select('depenses.*'); 
        } elseif ($sortDeca) {
            $query->orderBy('valeur', $sortDeca);
        }elseif ($search) {
            $query->where('note','like',"%$search%")
                  ->orWhere('valeur','like',"%$search%")
                  ->orWhereHas('depensenom',function ($q) use ($search) {
                    $q->where('nom','like',"%$search%");
                  });
        } else {
            $query->orderBy('date', $sortDate);
        } 

        $depenses = $query->paginate(10)->withQueryString();

        return view('depenses.index', compact('depenses'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $depensenoms = DepenseNom::all();
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
            "depense_noms_id" => "required"
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

    public function download($id)
    {

        $depense = Depense::find($id);

        if (!$depense->attachment || !$depense->attachment_name) {
            return redirect()->back()->with('error', 'No attachment found.');
        }

        $filename = $depense->attachment_name;

        return response($depense->attachment)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $filename);
    }
}
