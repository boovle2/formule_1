<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeamsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Red Bull Racing',
                'championships' => '6',
                'team_principal' => 'Christian Horner',
            ],
            [
                'name' => 'McLaren',
                'championships' => '10',
                'team_principal' => 'Andrea Stella',
            ],
            [
                'name' => 'Mercedes',
                'championships' => '8',
                'team_principal' => 'Toto Wolff',
            ],
            [
                'name' => 'Ferrari',
                'championships' => '16',
                'team_principal' => 'Fred Vasseur',
            ],
            [
                'name' => 'Williams',
                'championships' => '9',
                'team_principal' => 'James Vowles',
            ],
            [
                'name' => 'Racing Bulls',
                'championships' => '0',
                'team_principal' => 'Laurent Mekies',
            ],
            [
                'name' => 'Aston Martin',
                'championships' => '0',
                'team_principal' => 'Andy Cowell',
            ],
            [
                'name' => 'Haas F1 Team',
                'championships' => '0',
                'team_principal' => 'Ayao Komatsu',
            ],
            [
                'name' => 'Kick Sauber',
                'championships' => '0',
                'team_principal' => 'Jonathan Wheatley',
            ],
            [
                'name' => 'Alpine',
                'championships' => '0',
                'team_principal' => 'Oliver Oakes',
            ],
        ];

        foreach ($teams as $team) {
            DB::table('teams')->insert(
                [
                    'name' => $team['name'],
                    'championships' => $team['championships'],
                    'team_principal' => $team['team_principal'],
                ]
            );
        }
    }
}
