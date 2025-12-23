<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortMontant = $request->get('sortMontant');
        $sortClientNom = $request->get('sortClientNom');
        $sortNom = $request->get('sortNom');
        $search = $request->get('search');

        $query = Project::with('entrees');

        if ($sortClientNom) {
            $query->join('clients', 'clients.id', '=', 'projects.client_id')
                ->orderBy('clients.nom', $sortClientNom)
                ->select('projects.*'); 
        } elseif($sortMontant) {
            $query->orderBy('montant',$sortMontant);
        } elseif($sortNom) {
            $query->orderBy('nom',$sortNom);
        } elseif($search) {
            $query->where('nom','like',"%$search%")
                ->orWhere('montant','like',"%$search%")
                ->orWhereHas('client',function ($q) use ($search) {
                    $q->where('nom','like',"%$search%");
                })
                ->orWhereHas('entrees',function ($q) use ($search) {
                    $q->where('valeur','like',"%$search%");
                });
        }

        $projects = $query->paginate(10)->withQueryString();

        //dd($projects);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();

        return view('projects.create',compact("clients"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        "nom" => "required",
        "montant" => "required",
        "client_id" => "required"
        ]);

        Project::create($validated);

        if ($request->filled('redirect_to')) {
            return redirect($request->input('redirect_to'));
        }

        return redirect()->route('projects.index'); // default behavior

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
