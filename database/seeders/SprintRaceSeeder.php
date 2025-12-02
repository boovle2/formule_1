<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SprintRaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verwijder bestaande sprint entries (veilig bij foreign keys)
        DB::table('sprint_races')->delete();

        // Lijst van races waarvoor we een sprint willen aanmaken.
        // Pas deze lijst aan als jouw 2025 kalender anders is.
        $sprintRaceNames = [
            'Chinese Grand Prix',
            'Miami Grand Prix',
            'Belgian Grand Prix',
            'United States Grand Prix',
            'São Paulo Grand Prix',
            'Qatar Grand Prix',

        ];

        foreach ($sprintRaceNames as $name) {
            $race = DB::table('races')->where('name', $name)->first();

            if (! $race) {
                continue;
            }

            // Gebruik de hoofd race info en zet sprint op de dag ervoor (meestal zaterdag)
            $raceDate = Carbon::parse($race->date);
            $sprintDate = $raceDate->subDay()->toDateString();

            // Bereken sprint laps zodat de sprint ~100 km is.
            if (!empty($race->laps) && !empty($race->distance) && $race->laps > 0 && $race->distance > 0) {
                $lapLength = $race->distance / $race->laps; // km per lap
                $sprintLaps = max(1, (int) ceil(100 / $lapLength)); // rond omhoog zodat min 100km
                $sprintDistance = round($sprintLaps * $lapLength, 3);
            } else {
                // fallback: behoud eerdere ruwe schatting
                $sprintLaps = max(1, (int) floor(($race->laps ?? 1) * 0.35));
                $sprintDistance = isset($race->distance) ? round($race->distance * 0.25, 3) : null;

                DB::table('sprint_races')->insert([
                    'name' => 'Sprint: ' . $race->name,
                    'date' => $sprintDate,
                    'location' => $race->location,
                    'laps' => $sprintLaps,
                    'distance' => $sprintDistance,
                    'race_id' => $race->id,
                ]);
            }
        }
    }
}
