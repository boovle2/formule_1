<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// 
class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // gewenste volgorde met bijbehorende data (dd-mm-yyyy -> opgeslagen als Y-m-d)
        $races = [
            ['name' => 'Australian Grand Prix',     'date' => '2025-03-16', 'location' => 'Melbourne, Australia',        'laps' => 58, 'distance' => 307.574],
            ['name' => 'Chinese Grand Prix',        'date' => '2025-03-23', 'location' => 'Shanghai, China',            'laps' => 56, 'distance' => 305.066],
            ['name' => 'Japanese Grand Prix',       'date' => '2025-04-06', 'location' => 'Suzuka, Japan',              'laps' => 53, 'distance' => 307.471],
            ['name' => 'Bahrain Grand Prix',        'date' => '2025-04-13', 'location' => 'Sakhir, Bahrain',            'laps' => 57, 'distance' => 308.238],
            ['name' => 'Saudi Arabian Grand Prix',  'date' => '2025-04-20', 'location' => 'Jeddah, Saudi Arabia',      'laps' => 50, 'distance' => 308.450],
            ['name' => 'Miami Grand Prix',          'date' => '2025-05-04', 'location' => 'Miami, USA',                 'laps' => 57, 'distance' => 308.430],
            ['name' => 'Emilia-Romagna Grand Prix', 'date' => '2025-05-18', 'location' => 'Imola, Italy',               'laps' => 63, 'distance' => 309.049],
            ['name' => 'Monaco Grand Prix',         'date' => '2025-05-25', 'location' => 'Monte Carlo, Monaco',       'laps' => 78, 'distance' => 260.286],
            ['name' => 'Spanish Grand Prix',        'date' => '2025-06-01', 'location' => 'Barcelona, Spain',          'laps' => 66, 'distance' => 307.104],
            ['name' => 'Canadian Grand Prix',       'date' => '2025-06-15', 'location' => 'Montreal, Canada',          'laps' => 70, 'distance' => 305.270],
            ['name' => 'Austrian Grand Prix',       'date' => '2025-06-29', 'location' => 'Spielberg, Austria',        'laps' => 71, 'distance' => 306.452],
            ['name' => 'British Grand Prix',        'date' => '2025-07-06', 'location' => 'Silverstone, UK',          'laps' => 52, 'distance' => 306.198],
            ['name' => 'Belgian Grand Prix',        'date' => '2025-07-27', 'location' => 'Spa-Francorchamps, BE',    'laps' => 44, 'distance' => 308.052],
            ['name' => 'Hungarian Grand Prix',      'date' => '2025-08-03', 'location' => 'Budapest, Hungary',         'laps' => 70, 'distance' => 306.630],
            ['name' => 'Dutch Grand Prix',          'date' => '2025-08-31', 'location' => 'Zandvoort, Netherlands',   'laps' => 72, 'distance' => 306.587],
            ['name' => 'Italian Grand Prix',        'date' => '2025-09-07', 'location' => 'Monza, Italy',              'laps' => 53, 'distance' => 306.720],
            ['name' => 'Azerbaijan Grand Prix',     'date' => '2025-09-21', 'location' => 'Baku, Azerbaijan',         'laps' => 51, 'distance' => 306.049],
            ['name' => 'Singapore Grand Prix',      'date' => '2025-10-05', 'location' => 'Singapore',                 'laps' => 61, 'distance' => 309.316],
            ['name' => 'United States Grand Prix',  'date' => '2025-10-19', 'location' => 'Austin, USA',               'laps' => 56, 'distance' => 308.405],
            ['name' => 'Mexico City Grand Prix',    'date' => '2025-10-26', 'location' => 'Mexico City, Mexico',      'laps' => 71, 'distance' => 305.354],
            ['name' => 'São Paulo Grand Prix',      'date' => '2025-11-09', 'location' => 'São Paulo, Brazil',        'laps' => 71, 'distance' => 305.909],
            ['name' => 'Las Vegas Grand Prix',      'date' => '2025-11-22', 'location' => 'Las Vegas, USA',           'laps' => 50, 'distance' => 320.000],
            ['name' => 'Qatar Grand Prix',          'date' => '2025-11-30', 'location' => 'Lusail, Qatar',            'laps' => 57, 'distance' => 308.472],
            ['name' => 'Abu Dhabi Grand Prix',      'date' => '2025-12-07', 'location' => 'Yas Marina, UAE',          'laps' => 58, 'distance' => 305.355],
        ];

        // clear existing entries (safer than truncate if foreign keys present)
        DB::table('races')->delete();

        foreach ($races as $race) {
            DB::table('races')->insert([
                'name' => $race['name'],
                'date' => Carbon::parse($race['date'])->toDateString(),
                'location' => $race['location'],
                'laps' => $race['laps'],
                'distance' => $race['distance'],

            ]);
        }
    }
} 