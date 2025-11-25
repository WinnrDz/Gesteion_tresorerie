<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Entree;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class EntreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entrees = Entree::with("client")->get();

        return view("entrees.index",compact("entrees"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();

        return view("entrees.create" , compact("clients"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $Entree = $request->all();
        
        if ($Entree["type"] = "client") {
            $validated = $request->validate([
                "type" => "required",
                "client_id" => "required",
                "valeur" => "required",
                "date" => "required"
            ]);
        } 
        if ($Entree["type"] = "autre") {
            $validated = $request->validate([
                "type" => "required",
                "valeur" => "required",
                "date" => "required"
            ]);
        }

        Entree::create($validated);

        return redirect()->route('entrees.index')->with('success', 'entree created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Entree $entree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entree $entree)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entree $entree)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entree $entree)
    {
        //
    }
}
