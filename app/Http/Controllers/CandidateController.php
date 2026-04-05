<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Profilecv;
use App\Models\Skill;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Candidate::query();

    // SEARCH
    if ($request->search) {

        $words = array_filter(explode(' ', $request->search));

        $query->where(function ($q) use ($words) {
            foreach ($words as $word) {
                $q->orWhere('first_name', 'like', "%{$word}%")
                  ->orWhere('last_name', 'like', "%{$word}%");
            }
        });
    }

    // SORT
    $sort = $request->get('sort', 'desc'); // asc or desc

    $query->orderBy('notation', $sort);

    $candidates = $query->get();

    return view('candidates.index', compact('candidates'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skills = Skill::all();
        $profiles = Profilecv::all();
        return view('candidates.create', compact("skills", "profiles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Upload CV
        $path = $request->file('cv')->store('cvs', 'public');

        // Validation
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
            'interview_date' => 'nullable|date|after_or_equal:application_date',

            'skills' => ['required', 'json'],
            'profiles' => ['required', 'json'],
        ]);

        // Extract & remove from insert
        $skillsJson = $validated['skills'];
        $profilesJson = $validated['profiles'];

        unset($validated['skills'], $validated['profiles']);

        // Add CV path
        $validated['cv'] = $path;

        // Create candidate
        $candidate = Candidate::create($validated);

        // =========================
        // SKILLS
        // =========================
        $skillsArray = json_decode($skillsJson, true);
        $skillIds = [];

        foreach ($skillsArray as $skillName) {
            $skill = Skill::firstOrCreate(['name' => $skillName]);
            $skillIds[] = $skill->id;
        }

        $candidate->skills()->sync($skillIds);

        // =========================
        // PROFILES (same logic)
        // =========================
        $profilesArray = json_decode($profilesJson, true);
        $profileIds = [];

        foreach ($profilesArray as $profileName) {
            $profile = Profilecv::firstOrCreate(['name' => $profileName]);
            $profileIds[] = $profile->id;
        }

        $candidate->profilecvs()->sync($profileIds);

        // Redirect
        if ($request->filled('redirect_to')) {
            return redirect($request->input('redirect_to'));
        }

        return redirect()->route('candidates.index');
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
