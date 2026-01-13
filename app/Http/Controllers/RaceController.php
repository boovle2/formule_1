<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\RaceModel;
use App\Models\SprintRaceModel;
use App\Models\QualifyingRaceModel;
use App\Models\QualifyingResult;
use App\Models\standings as StandingsModel;


class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $races = RaceModel::all();
        return view('races.index', compact('races'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('races.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'laps' => 'nullable|integer',
            'distance' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('races', 'public');
        }

        RaceModel::create($validatedData);

        return redirect()->route('races.index')->with('success', 'Race created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sprint_races = SprintRaceModel::where('race_id', $id)->get();
        $race = RaceModel::findOrFail($id);

        // Load standings/results for this race (if any)
        $raceResults = StandingsModel::where('race_id', $id)
            ->where('session_type', 'race')
            ->with('driver')
            ->orderBy('placement')
            ->get();

        $sprintResultsBySession = StandingsModel::where('race_id', $id)
            ->where('session_type', 'sprint')
            ->with('driver')
            ->orderBy('session_id')
            ->orderBy('placement')
            ->get()
            ->groupBy('session_id');

        // Load qualifying races and their results (if any)
        $qualifying_races = QualifyingRaceModel::where('race_id', $id)->get();
        foreach ($qualifying_races as $qr) {
            $qr->results = QualifyingResult::where('qualifying_race_id', $qr->id)
                ->with('driver')
                ->orderBy('placement')
                ->get();
        }

        return view('races.show', compact('race', 'sprint_races', 'raceResults', 'sprintResultsBySession', 'qualifying_races'));
    }

    /**
     * Return qualifying results (driver IDs ordered) for a given race as JSON.
     */
    public function qualifyingResults(string $id)
    {
        // Find the main qualifying race for this race (take first)
        $qr = QualifyingRaceModel::where('race_id', $id)->first();
        if (! $qr) {
            return response()->json(['drivers' => []]);
        }

        $results = QualifyingResult::where('qualifying_race_id', $qr->id)
            ->orderBy('placement')
            ->pluck('driver_id')
            ->toArray();

        return response()->json(['drivers' => $results]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $race = RaceModel::findOrFail($id);
        return view('races.edit', compact('race'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'laps' => 'nullable|integer',
            'distance' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $race = RaceModel::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($race->image) {
                Storage::disk('public')->delete($race->image);
            }
            $validatedData['image'] = $request->file('image')->store('races', 'public');
        }

        $race->update($validatedData);

        return redirect()->route('races.show', $race->id)->with('success', 'Race updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $race = RaceModel::findOrFail($id);
        
        if ($race->image) {
            Storage::disk('public')->delete($race->image);
        }
        
        $race->delete();
        return redirect()->route('races.index')->with('success', 'Race deleted successfully.');
    }
}
