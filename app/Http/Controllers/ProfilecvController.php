<?php

namespace App\Http\Controllers;

use App\Models\Profilecv;
use Illuminate\Http\Request;

class ProfilecvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profilecv::all();

        return view('profilecvs.index', compact("profiles"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profilecvs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $validated = $request->validate([
            "name" => "required"
        ]);

        

        Profilecv::create($validated);


        
        if ($request->filled('redirect_to')) {
            return redirect($request->input('redirect_to'));
        }

        return redirect()->route('profilecvs.index'); // default behavior
    }


    /**
     * Display the specified resource.
     */
    public function show(profilecv $profilecv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(profilecv $profilecv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, profilecv $profilecv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(profilecv $profilecv)
    {
        //
    }
}
