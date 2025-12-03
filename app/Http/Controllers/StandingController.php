<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\standings;
use App\Models\DriverModel;
use App\Models\TeamModel;
use App\Models\RaceModel;

class StandingController extends Controller
{
    // F1 2024 Points System
    private $pointsTable = [
        1 => 25,
        2 => 18,
        3 => 15,
        4 => 12,
        5 => 10,
        6 => 8,
        7 => 6,
        8 => 4,
        9 => 2,
        10 => 1,
    ];

    /**
     * Display driver standings
     */
    public function index()
    {
        $drivers = DriverModel::with('team')->get();

        // Calculate total points for each driver
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
     * Show form for entering race results (Admin)
     */
    public function create()
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $races = RaceModel::all();
        $drivers = DriverModel::with('team')->get();
        return view('standings.create', compact('races', 'drivers'));
    }

    /**
     * Store race results and update standings (Admin)
     */
    public function store(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'race_id' => 'required|exists:races,id',
            'results' => 'required|array',
            'results.*.driver_id' => 'required|exists:drivers,id',
            'results.*.placement' => 'required|integer|min:1|max:20',
        ]);

        // Delete existing standings for this race
        standings::where('race_id', $request->race_id)->delete();

        // Store new results
        foreach ($request->results as $result) {
            if (!empty($result['driver_id']) && !empty($result['placement'])) {
                $placement = (int)$result['placement'];
                $points = $this->pointsTable[$placement] ?? 0;

                standings::create([
                    'driver_id' => $result['driver_id'],
                    'race_id' => $request->race_id,
                    'placement' => $placement,
                    'points' => $points,
                ]);

                // Update driver points
                $driver = DriverModel::find($result['driver_id']);
                $driver->points += $points;
                $driver->save();

                // Update team points
                if ($driver->team_id) {
                    $team = TeamModel::find($driver->team_id);
                    $team->points += $points;
                    $team->save();
                }
            }
        }

        return redirect()->route('standings.index')->with('success', 'Race results updated successfully.');
    }

    /**
     * Show race results (Public)
     */
    public function show(string $id)
    {
        $race = RaceModel::findOrFail($id);
        $results = standings::where('race_id', $id)
            ->with('driver')
            ->orderBy('placement')
            ->get();

        return view('standings.show', compact('race', 'results'));
    }

    /**
     * Edit race results (Admin)
     */
    public function edit(string $id)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $race = RaceModel::findOrFail($id);
        $drivers = DriverModel::all();
        $results = standings::where('race_id', $id)->get()->keyBy('driver_id');

        return view('standings.edit', compact('race', 'drivers', 'results'));
    }

    /**
     * Update race results (Admin)
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

        // Revert old points
        $oldResults = standings::where('race_id', $id)->get();
        foreach ($oldResults as $result) {
            $driver = DriverModel::find($result->driver_id);
            $driver->points -= $result->points;
            $driver->save();

            // Revert team points
            if ($driver->team_id) {
                $team = TeamModel::find($driver->team_id);
                $team->points -= $result->points;
                $team->save();
            }
        }

        // Delete existing standings for this race
        standings::where('race_id', $id)->delete();

        // Store new results
        foreach ($request->results as $result) {
            if (!empty($result['driver_id']) && !empty($result['placement'])) {
                $placement = (int)$result['placement'];
                $points = $this->pointsTable[$placement] ?? 0;

                standings::create([
                    'driver_id' => $result['driver_id'],
                    'race_id' => $id,
                    'placement' => $placement,
                    'points' => $points,
                ]);

                // Update driver points
                $driver = DriverModel::find($result['driver_id']);
                $driver->points += $points;
                $driver->save();

                // Update team points
                if ($driver->team_id) {
                    $team = TeamModel::find($driver->team_id);
                    $team->points += $points;
                    $team->save();
                }
            }
            $results = standings::where('race_id', $id)->get();

            // Revert points
            foreach ($results as $result) {
                $driver = DriverModel::find($result->driver_id);
                $driver->points -= $result->points;
                $driver->save();

                // Revert team points
                if ($driver->team_id) {
                    $team = TeamModel::find($driver->team_id);
                    $team->points -= $result->points;
                    $team->save();
                }
            }

            standings::where('race_id', $id)->delete();
            if (Auth::guest() || Auth::user()->role !== 'admin') {
                abort(403, 'Unauthorized');
            }

            $results = standings::where('race_id', $id)->get();

            // Revert points
            foreach ($results as $result) {
                $driver = DriverModel::find($result->driver_id);
                $driver->points -= $result->points;
                $driver->save();
            }

            standings::where('race_id', $id)->delete();

            return redirect()->route('standings.index')->with('success', 'Race results deleted.');
        }
    }
}
