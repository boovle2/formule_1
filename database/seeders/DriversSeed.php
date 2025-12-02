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
            ['name' => 'Max Verstappen', 'team_id' => 1],
            ['name' => 'Liam Lawson', 'team_id' => 1],
            ['name' => 'Charles Leclerc', 'team_id' => 2],
            ['name' => 'Lewis Hamilton', 'team_id' => 2],
            ['name' => 'Lando Norris', 'team_id' => 3],
            ['name' => 'Oscar Piastri', 'team_id' => 3],
            ['name' => 'George Russell', 'team_id' => 4],
            ['name' => 'Kimi Antonelli', 'team_id' => 4],
            ['name' => 'Fernando Alonso', 'team_id' => 5],
            ['name' => 'Lance Stroll', 'team_id' => 5],
            ['name' => 'Pierre Gasly', 'team_id' => 6],
            ['name' => 'Jack Doohan', 'team_id' => 6],
            ['name' => 'Esteban Ocon', 'team_id' => 7],
            ['name' => 'Oliver Bearman', 'team_id' => 7],
            ['name' => 'Yuki Tsunoda', 'team_id' => 8],
            ['name' => 'Isack Hadjar', 'team_id' => 8],
            ['name' => 'Alex Albon', 'team_id' => 9],
            ['name' => 'Carlos Sainz', 'team_id' => 9],
            ['name' => 'Nico Hülkenberg', 'team_id' => 10],
            ['name' => 'Gabriel Bortoleto', 'team_id' => 10],
        ];

        foreach ($drivers as $driver) {
            DB::table('drivers')->insert($driver);
        }
    }
}
