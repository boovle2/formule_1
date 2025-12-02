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
                'points' => 500,
                'championships' => '7',
                'team_principal' => 'Christian Horner',
            ],
            [
                'name' => 'Scuderia Ferrari',
                'points' => 450,
                'championships' => '8',
                'team_principal' => 'Mattia Binotto',
            ],
            [
                'name' => 'McLaren F1 Team',
                'points' => 300,
                'championships' => '12',
                'team_principal' => 'Andreas Seidl',
            ],
            [
                'name' => 'Mercedes-AMG Petronas',
                'points' => 400,
                'championships' => '9',
                'team_principal' => 'Toto Wolff',
            ],
            [
                'name' => 'Alpine F1 Team',
                'points' => 200,
                'championships' => '2',
                'team_principal' => 'Otmar Szafnauer',
            ],
            [
                'name' => 'Scuderia AlphaTauri',
                'points' => 150,
                'championships' => '0',
                'team_principal' => 'Franz Tost',
            ],
            [
                'name' => 'Aston Martin Cognizant',
                'points' => 250,
                'championships' => '0',
                'team_principal' => 'Mike Krack',
            ],
            [
                'name' => 'Williams Racing',
                'points' => 100,
                'championships' => '9',
                'team_principal' => 'Jost Capito',
            ],
            [
                'name' => 'Alfa Romeo F1 Team',
                'points' => 120,
                'championships' => '2',
                'team_principal' => 'Frédéric Vasseur',
            ],
            [
                'name' => 'Haas F1 Team',
                'points' => 80,
                'championships' => '0',
                'team_principal' => 'Guenther Steiner',
            ],
        ];

        foreach ($teams as $team) {
            DB::table('teams')->insert(
                [
                    'name' => $team['name'],
                    'points' => $team['points'],
                    'championships' => $team['championships'],
                    'team_principal' => $team['team_principal'],
                ]
            );
        }

    }
}
