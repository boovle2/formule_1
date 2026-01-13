<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QualifyingRaceModel;
use App\Models\QualifyingResult;
use App\Models\DriverModel;

class QualifyingResultController extends Controller
{
    public function create($raceId)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $drivers = DriverModel::with('team')->get();
        $raceId = (int)$raceId;

        // If there is an existing qualifying race, get its results
        $qualifying = QualifyingRaceModel::where('race_id', $raceId)->first();
        $results = collect();
        if ($qualifying) {
            $results = QualifyingResult::where('qualifying_race_id', $qualifying->id)->pluck('placement', 'driver_id');
        }

        return view('qualifying.create', compact('drivers', 'raceId', 'qualifying', 'results'));
    }

    public function store(Request $request, $raceId)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'nullable|string|max:255',
            'results' => 'required|array',
            'results.*.driver_id' => 'required|exists:drivers,id',
            'results.*.placement' => 'nullable|integer|min:1|max:99',
            'results.*.time' => 'nullable|string|max:50',
        ]);

        // Create or get qualifying race
        $qualifying = QualifyingRaceModel::firstOrCreate([
            'race_id' => $raceId,
        ], [
            'name' => $request->input('name', 'Qualifying'),
            'date' => now(),
        ]);

        // Delete old results
        QualifyingResult::where('qualifying_race_id', $qualifying->id)->delete();

        foreach ($request->input('results') as $r) {
            if (!empty($r['driver_id'])) {
                QualifyingResult::create([
                    'qualifying_race_id' => $qualifying->id,
                    'driver_id' => $r['driver_id'],
                    'placement' => isset($r['placement']) ? (int)$r['placement'] : 0,
                    'time' => $r['time'] ?? null,
                ]);
            }
        }

        return redirect()->route('races.show', $raceId)->with('success', 'Qualifying results saved.');
    }

    public function edit($raceId)
    {
        // reuse create view for editing
        return $this->create($raceId);
    }

    public function destroy($raceId)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $qualifying = QualifyingRaceModel::where('race_id', $raceId)->first();
        if ($qualifying) {
            QualifyingResult::where('qualifying_race_id', $qualifying->id)->delete();
            $qualifying->delete();
        }

        return redirect()->route('races.show', $raceId)->with('success', 'Qualifying results deleted.');
    }
}
