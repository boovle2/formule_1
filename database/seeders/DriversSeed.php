<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DriversSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = [
            // Team 1: Red Bull Racing
            ['Fname' => 'Max',   'Lname' => 'Verstappen', 'team_id' => 1, 'number' => 1,  'points' => 0, 'image' => 'drivers/2025redbullracingmaxver01right.avif'],
            ['Fname' => 'Yuki',  'Lname' => 'Tsunoda',     'team_id' => 1, 'number' => 30, 'points' => 0, 'image' => 'drivers/2025redbullracingyuktsu01right.avif'],

            // Team 2: McLaren
            ['Fname' => 'Lando', 'Lname' => 'Norris',     'team_id' => 2, 'number' => 4,  'points' => 0, 'image' => 'drivers/dpX0GvUNxfoRt48gVO3rhbqeuaK8CtUxtK3eiG8A.avif'],
            ['Fname' => 'Oscar', 'Lname' => 'Piastri',    'team_id' => 2, 'number' => 81, 'points' => 0, 'image' => 'drivers/I5263OK9x5JCgzYNCNz7n51QsrT5iUsOcHrxkM3k.avif'],

            // Team 3: Mercedes
            ['Fname' => 'George', 'Lname' => 'Russell',    'team_id' => 3, 'number' => 63, 'points' => 0, 'image' => 'drivers/2025mercedesgeorus01right.avif'],
            ['Fname' => 'Andrea', 'Lname' => 'Kimi Antonelli', 'team_id' => 3, 'number' => 12, 'points' => 0, 'image' => 'drivers/2025mercedesandant01right.avif'],

            // Team 4: Ferrari
            ['Fname' => 'Charles', 'Lname' => 'Leclerc',   'team_id' => 4, 'number' => 16, 'points' => 0, 'image' => 'drivers/2025ferrarichalec01right.avif'],
            ['Fname' => 'Lewis',  'Lname' => 'Hamilton',  'team_id' => 4, 'number' => 44, 'points' => 0, 'image' => 'drivers/2025ferrarilewham01right.avif'],

            // Team 5: Aston Martin
            ['Fname' => 'Fernando', 'Lname' => 'Alonso',   'team_id' => 7, 'number' => 14, 'points' => 0, 'image' => 'drivers/2025astonmartinferalo01right.avif'],
            ['Fname' => 'Lance',   'Lname' => 'Stroll',   'team_id' => 7, 'number' => 18, 'points' => 0, 'image' => 'drivers/2025astonmartinlanstr01right.avif'],

            // Team 6: Alpine
            ['Fname' => 'Pierre', 'Lname' => 'Gasly',      'team_id' => 10, 'number' => 10, 'points' => 0, 'image' => 'drivers/2025alpinepiegas01right.avif'],
            ['Fname' => 'Franco', 'Lname' => 'Colapinto',  'team_id' => 10, 'number' => 43, 'points' => 0, 'image' => 'drivers/2025alpinefracol01right.avif'],

            // Team 7: Racing Bulls (Visa Cash App RB)
            ['Fname' => 'Isack', 'Lname' => 'Hadjar',      'team_id' => 6, 'number' => 6,   'points' => 0, 'image' => 'drivers/2025racingbullsisahad01right.avif'],
            ['Fname' => 'Liam',  'Lname' => 'Lawson',     'team_id' => 6, 'number' => 22,  'points' => 0, 'image' => 'drivers/2025racingbullslialaw01right.avif'],

            // Team 8: Haas F1 Team
            ['Fname' => 'Esteban', 'Lname' => 'Ocon',       'team_id' => 8, 'number' => 31,  'points' => 0, 'image' => 'drivers/2025haasf1teamestoco01right.avif'],
            ['Fname' => 'Oliver', 'Lname' => 'Bearman',     'team_id' => 8, 'number' => 87,  'points' => 0, 'image' => 'drivers/2025haasf1teamolibea01right.avif'],

            // Team 9: Williams
            ['Fname' => 'Alexander', 'Lname' => 'Albon',    'team_id' => 5, 'number' => 23,  'points' => 0, 'image' => 'drivers/2025williamsalealb01right.avif'],
            ['Fname' => 'Carlos',   'Lname' => 'Sainz',    'team_id' => 5, 'number' => 55,  'points' => 0, 'image' => 'drivers/2025williamscarsai01right.avif'],

            // Team 10: Kick Sauber
            ['Fname' => 'Nico',    'Lname' => 'Hülkenberg', 'team_id' => 9, 'number' => 27,  'points' => 0, 'image' => 'drivers/2025kicksaubernichul01right.avif'],
            ['Fname' => 'Gabriel', 'Lname' => 'Bortoleto', 'team_id' => 9, 'number' => 5,   'points' => 0, 'image' => 'drivers/2025kicksaubergabbor01right.avif'],
        ];

        foreach ($drivers as $driver) {
            DB::table('drivers')->insert($driver);
        }
    }
}
