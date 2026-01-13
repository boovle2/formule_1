<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\standings;
use App\Models\DriverModel;
use App\Models\TeamModel;
use App\Models\RaceModel;
use App\Models\SprintRaceModel;
use App\Services\PointsCalculator;

class StandingController extends Controller
{
    // Points logic extracted to App\Services\PointsCalculator
    // Use PointsCalculator::getPointsTable($sessionType) or PointsCalculator::pointsForPlacement(...)


    /**
     * Display driver standings (from all session types)
     */
    public function index()
    {
        $drivers = DriverModel::with('team')->get();

        // Calculate total points for each driver (from all sessions)
        $driverStandings = $drivers->map(function ($driver) {
            $totalPoints = standings::where('driver_id', $driver->id)->sum('points');
            $driver->total_points = $totalPoints;
            return $driver;
        })->sortByDesc('total_points')->values();

        // Team standings
        $teamStandings = TeamModel::all()->map(function ($team) {
            $totalPoints = standings::whereIn(
                'driver_id',
                DriverModel::where('team_id', $team->id)->pluck('id')
            )->sum('points');
            $team->total_points = $totalPoints;
            return $team;
        })->sortByDesc('total_points')->values();

        return view('standings.index', compact('driverStandings', 'teamStandings'));
    }

    /**
     * Show form for entering race/sprint results (Admin only)
     */
    public function create()
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $races = RaceModel::all();
        $sprintRaces = SprintRaceModel::all();
        $drivers = DriverModel::with('team')->get();

        return view('standings.create', compact('races', 'sprintRaces', 'drivers'));
    }

    /**
     * Store race/sprint results and update standings (Admin only)
     */
    public function store(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $sessionType = $request->input('session_type', 'race');
        $raceId = $request->input('race_id');
        $sessionId = $request->input('session_id');

        if (!$raceId) {
            return back()->withErrors(['Race selection required.']);
        }

        // For sprint races, session_id must be set (it's the sprint_id)
        // For main races, session_id = race_id
        if ($sessionType === 'sprint' && !$sessionId) {
            return back()->withErrors(['Sprint race selection required.']);
        }

        if ($sessionType === 'race') {
            $sessionId = $raceId; // For main race, session_id = race_id
        }

        $request->validate([
            'results' => 'required|array',
            'results.*.driver_id' => 'required|exists:drivers,id',
            'results.*.placement' => 'required|integer|min:1|max:20',
        ]);

        // Delete existing standings for this session
        standings::where('race_id', $raceId)
            ->where('session_type', $sessionType)
            ->where('session_id', $sessionId)
            ->delete();

        $pointsTable = PointsCalculator::getPointsTable($sessionType);

        // Store new results
        foreach ($request->results as $result) {
            if (!empty($result['driver_id']) && !empty($result['placement'])) {
                $placement = (int)$result['placement'];
                $points = $pointsTable[$placement] ?? 0;

                standings::create([
                    'driver_id' => $result['driver_id'],
                    'race_id' => $raceId,
                    'session_type' => $sessionType,
                    'session_id' => $sessionId,
                    'placement' => $placement,
                    'points' => $points,
                ]);

                // Update driver & team points (recalculate from standings)
                $driver = DriverModel::find($result['driver_id']);
                if ($driver) {
                    $driver->refreshPoints();
                    if ($driver->team_id) {
                        $team = TeamModel::find($driver->team_id);
                        if ($team) $team->refreshPoints();
                    }
                }
            }
        }

        return redirect()->route('standings.index')->with('success', 'Results saved successfully.');
    }

    /**
     * Show race results (Public view only)
     */
    public function show(string $id)
    {
        $race = RaceModel::findOrFail($id);
        $results = standings::where('race_id', $id)
            ->where('session_type', 'race')
            ->with('driver')
            ->orderBy('placement')
            ->get();

        return view('standings.show', compact('race', 'results'));
    }

    /**
     * Edit results (Admin only)
     */
    public function edit(string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $race = RaceModel::findOrFail($id);
        $drivers = DriverModel::with('team')->get();
        $results = standings::where('race_id', $id)
            ->where('session_type', 'race')
            ->get()
            ->keyBy('driver_id');

        return view('standings.edit', compact('race', 'drivers', 'results'));
    }

    /**
     * Update results (Admin only)
     */
    public function update(Request $request, string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'results' => 'required|array',
            'results.*.driver_id' => 'required|exists:drivers,id',
            'results.*.placement' => 'required|integer|min:1|max:20',
        ]);

        $oldResults = standings::where('race_id', $id)->where('session_type', 'race')->get();
        $affectedDriverIds = $oldResults->pluck('driver_id')->unique()->toArray();

        // Delete existing standings
        standings::where('race_id', $id)->where('session_type', 'race')->delete();

        $pointsTable = PointsCalculator::getPointsTable('race');

        $createdDriverIds = [];
        // Store new results
        foreach ($request->results as $result) {
            if (!empty($result['driver_id']) && !empty($result['placement'])) {
                $placement = (int)$result['placement'];
                $points = $pointsTable[$placement] ?? 0;

                standings::create([
                    'driver_id' => $result['driver_id'],
                    'race_id' => $id,
                    'session_type' => 'race',
                    'session_id' => $id,
                    'placement' => $placement,
                    'points' => $points,
                ]);

                $createdDriverIds[] = $result['driver_id'];
            }
        }

        // Recalculate points for all affected drivers and their teams
        $allDriverIds = array_unique(array_merge($affectedDriverIds, $createdDriverIds));
        foreach ($allDriverIds as $driverId) {
            $driver = DriverModel::find($driverId);
            if ($driver) {
                $driver->refreshPoints();
                if ($driver->team_id) {
                    $team = TeamModel::find($driver->team_id);
                    if ($team) $team->refreshPoints();
                }
            }
        }

        return redirect()->route('standings.index')->with('success', 'Race results updated.');
    }

    /**
     * Delete results (Admin only)
     */
    public function destroy(string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $driverIds = standings::where('race_id', $id)->pluck('driver_id')->unique();

        // Delete standings for this race
        standings::where('race_id', $id)->delete();

        // Recalculate points for affected drivers and teams
        foreach ($driverIds as $driverId) {
            $driver = DriverModel::find($driverId);
            if ($driver) {
                $driver->refreshPoints();
                if ($driver->team_id) {
                    $team = TeamModel::find($driver->team_id);
                    if ($team) $team->refreshPoints();
                }
            }
        }

        return redirect()->route('standings.index')->with('success', 'Race results deleted.');
    }
}
