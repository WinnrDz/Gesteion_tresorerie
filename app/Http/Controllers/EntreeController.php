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
        
        if ($Entree["type"] == "client") {
            $validated = $request->validate([
                "type" => "required",
                "client_id" => "required",
                "valeur" => "required",
                "attachment" => "",
                "date" => "required"
            ]);
        } 
        if ($Entree["type"] == "autre") {    
            $validated = $request->validate([
                "type" => "required",
                "valeur" => "required",
                "attachment" => "",
                "date" => "required"
            ]);
        }

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $validated['attachment'] = file_get_contents($file->getRealPath());
            $validated['attachment_name'] = $file->getClientOriginalName();
        } else {
            $validated['attachment'] = null;
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

    public function download($id) {

        $entree = Entree::find($id);

        if (!$entree->attachment || !$entree->attachment_name) {
            return redirect()->back()->with('error', 'No attachment found.');
        }

        $filename = $entree->attachment_name;

        return response($entree->attachment)
        ->header('Content-Type','application/octet-stream')
        ->header('Content-Disposition', 'attachment; filename="' . $filename);

    }
}
