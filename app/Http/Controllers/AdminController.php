<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\RaceModel;
use App\Models\DriverModel;
use App\Models\TeamModel;
use App\Models\SprintRaceModel;
use App\Models\QualifyingRaceModel;
use App\Models\QualifyingResult;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $races = RaceModel::orderBy('date', 'asc')->get();
        $drivers = DriverModel::with('team')->orderBy('Fname')->get();
        $teams = TeamModel::orderBy('name')->get();
        $sprintRaces = SprintRaceModel::with('race')->orderBy('date', 'asc')->get();
        $qualifyingRaces = QualifyingRaceModel::with('race')->orderBy('date', 'asc')->get();

        return view('admin.dashboard', compact('races', 'drivers', 'teams', 'sprintRaces', 'qualifyingRaces'));
    }

    public function storeRace(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'laps' => 'nullable|integer',
            'distance' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('races', 'public');
        }

        $race = RaceModel::create($data);

        // Automatically create qualifying race
        QualifyingRaceModel::create([
            'race_id' => $race->id,
            'name' => $race->name . ' - Qualifying',
            'date' => $race->date,
            'location' => $race->location,
        ]);

        return back()->with('success', 'Race created. Qualifying automatically created.');
    }

    public function storeDriver(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'Fname' => 'required|string|max:100',
            'Lname' => 'required|string|max:100',
            'number' => 'nullable|integer',
            'team_id' => 'nullable|exists:teams,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('drivers', 'public');
        }

        // default points
        $data['points'] = $data['points'] ?? 0;

        DriverModel::create($data);

        return back()->with('success', 'Driver created.');
    }

    public function storeTeam(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'team_principal' => 'nullable|string|max:255',
            'championships' => 'nullable|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:4096',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('teams', 'public');
        }

        $data['points'] = $data['points'] ?? 0;

        TeamModel::create($data);

        return back()->with('success', 'Team created.');
    }

    public function updateRace(Request $request, string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $race = RaceModel::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'laps' => 'nullable|integer',
            'distance' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($race->image) {
                Storage::disk('public')->delete($race->image);
            }
            $data['image'] = $request->file('image')->store('races', 'public');
        }

        $race->update($data);

        return back()->with('success', 'Race updated.');
    }

    public function updateDriver(Request $request, string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $driver = DriverModel::findOrFail($id);

        $data = $request->validate([
            'Fname' => 'required|string|max:100',
            'Lname' => 'required|string|max:100',
            'number' => 'nullable|integer',
            'team_id' => 'nullable|exists:teams,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($driver->image) {
                Storage::disk('public')->delete($driver->image);
            }
            $data['image'] = $request->file('image')->store('drivers', 'public');
        }

        $driver->update($data);

        return back()->with('success', 'Driver updated.');
    }

    public function updateTeam(Request $request, string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $team = TeamModel::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'team_principal' => 'nullable|string|max:255',
            'championships' => 'nullable|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:4096',
        ]);

        if ($request->hasFile('logo')) {
            if ($team->logo) {
                Storage::disk('public')->delete($team->logo);
            }
            $data['logo'] = $request->file('logo')->store('teams', 'public');
        }

        $team->update($data);

        return back()->with('success', 'Team updated.');
    }

    public function deleteRace(string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $race = RaceModel::findOrFail($id);

        if ($race->image) {
            Storage::disk('public')->delete($race->image);
        }

        $race->delete();

        return back()->with('success', 'Race deleted.');
    }

    public function deleteDriver(string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $driver = DriverModel::findOrFail($id);

        if ($driver->image) {
            Storage::disk('public')->delete($driver->image);
        }

        $driver->delete();

        return back()->with('success', 'Driver deleted.');
    }

    public function deleteTeam(string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $team = TeamModel::findOrFail($id);

        if ($team->logo) {
            Storage::disk('public')->delete($team->logo);
        }

        $team->delete();

        return back()->with('success', 'Team deleted.');
    }

    // Sprint Race methods
    public function storeSprintRace(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'race_id' => 'required|exists:races,id',
            'name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'laps' => 'nullable|integer',
            'distance' => 'nullable|numeric',
        ]);

        SprintRaceModel::create($data);

        return back()->with('success', 'Sprint race created.');
    }

    public function deleteSprintRace(string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $sprintRace = SprintRaceModel::findOrFail($id);
        $sprintRace->delete();

        return back()->with('success', 'Sprint race deleted.');
    }

    // Qualifying Race methods
    public function storeQualifyingRace(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'race_id' => 'required|exists:races,id',
            'name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
        ]);

        QualifyingRaceModel::create($data);

        return back()->with('success', 'Qualifying race created.');
    }

    public function deleteQualifyingRace(string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $qualifyingRace = QualifyingRaceModel::findOrFail($id);
        $qualifyingRace->delete();

        return back()->with('success', 'Qualifying race deleted.');
    }

    // Qualifying Results form
    public function qualifyingResultsForm(string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $qualifying = QualifyingRaceModel::with('race')->findOrFail($id);
        $drivers = DriverModel::orderBy('Fname')->get();
        $results = QualifyingResult::where('qualifying_id', $id)->orderBy('position')->get();

        return view('admin.qualifying-results', compact('qualifying', 'drivers', 'results'));
    }

    public function storeQualifyingResults(Request $request, string $id)
    {
        try {
            if (Auth::guest() || Auth::user()->role !== 'admin') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            // $id is race_id, find or get the qualifying race
            $race = RaceModel::findOrFail($id);
            $qualifying = QualifyingRaceModel::where('race_id', $id)->first();
            
            if (!$qualifying) {
                // Create qualifying if it doesn't exist
                $qualifying = QualifyingRaceModel::create([
                    'race_id' => $id,
                    'name' => $race->name . ' - Qualifying',
                    'date' => $race->date,
                    'location' => $race->location,
                ]);
            }

            $data = $request->validate([
                'results' => 'required|array',
                'results.*.driver_id' => 'nullable|exists:drivers,id',
                'results.*.position' => 'required|integer|min:1',
            ]);

            // Delete existing results
            QualifyingResult::where('qualifying_id', $qualifying->id)->delete();

            // Store new results
            foreach ($data['results'] as $result) {
                if ($result['driver_id']) {
                    QualifyingResult::create([
                        'qualifying_id' => $qualifying->id,
                        'driver_id' => $result['driver_id'],
                        'position' => $result['position'],
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Qualifying results saved.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Qualifying save error: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
