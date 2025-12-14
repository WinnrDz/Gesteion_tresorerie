<?php

namespace App\Http\Controllers;

use App\Models\Depensenom;
use Illuminate\Http\Request;

class DepensenomController extends Controller
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

        return view("depensesNoms.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            "nom" => "required",
            "type" => "required"
        ]);
        DepenseNom::create($validated);

       if($request->filled('redirect_to')) {
        return redirect($request->input('redirect_to'));
    }

    return redirect()->route('depenses.index'); // default behavior


    }

    /**
     * Display the specified resource.
     */
    public function show(Depensenom $depensenom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depensenom $depensenom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Depensenom $depensenom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depensenom $depensenom)
    {
        //
    }
}
