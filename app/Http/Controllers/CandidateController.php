<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Skill;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidates = Candidate::all();

        return view('candidates.index',compact("candidates"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $skills = Skill::all();
        return view('candidates.create',compact("skills"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $path = $request->file('cv')->store('cvs', 'public');

        $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:candidates,email',
        'phone' => 'required',
        'location' => 'nullable|string|max:255',
        'availability' => 'nullable|string|max:255',

        'exp_years' => 'nullable|integer|min:0',

        'linkedIn' => 'nullable|url',
        'github' => 'nullable|url',
        'portfolio_url' => 'nullable|url',

        'recruitment_pipeline' => 'required|in:new,interview,shortlisted,offer,rejected,hired',

        'notation' => 'required|integer|min:0|max:100',

        'salary' => 'nullable|numeric|min:0',

        'application_date' => 'required|date',

        'interview_date' => 'nullable|date|after_or_equal:application_date'
    ]);

    $validated['cv'] = $path;

    




    $candidate = Candidate::create($validated);





    // 2 Process skills
    $skillsArray = json_decode($request->skills, true);

    $skillIds = [];

    foreach ($skillsArray as $skillName) {
        // Find or create skill
        $skill = Skill::firstOrCreate(['name' => $skillName]);
        $skillIds[] = $skill->id;
    }

    // 3 Attach skills to candidate
    $candidate->skills()->sync($skillIds);

        if ($request->filled('redirect_to')) {
                    return redirect($request->input('redirect_to'));
        }

        return redirect()->route('candidates.index'); // default behavior

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $candidate = Candidate::findOrFail($id);
        return view('candidates.show', compact('candidate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        //
    }
}
