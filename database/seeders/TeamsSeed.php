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
                'championships' => '7',
                'team_principal' => 'Christian Horner',
            ],
            [
                'name' => 'Scuderia Ferrari',
                'championships' => '8',
                'team_principal' => 'Mattia Binotto',
            ],
            [
                'name' => 'McLaren F1 Team',
                'championships' => '12',
                'team_principal' => 'Andreas Seidl',
            ],
            [
                'name' => 'Mercedes-AMG Petronas',
                'championships' => '9',
                'team_principal' => 'Toto Wolff',
            ],
            [
                'name' => 'Alpine F1 Team',
                'championships' => '2',
                'team_principal' => 'Otmar Szafnauer',
            ],
            [
                'name' => 'Scuderia AlphaTauri',
                'championships' => '0',
                'team_principal' => 'Franz Tost',
            ],
            [
                'name' => 'Aston Martin Cognizant',
                'championships' => '0',
                'team_principal' => 'Mike Krack',
            ],
            [
                'name' => 'Williams Racing',
                'championships' => '9',
                'team_principal' => 'Jost Capito',
            ],
            [
                'name' => 'Alfa Romeo F1 Team',
                'championships' => '2',
                'team_principal' => 'Frédéric Vasseur',
            ],
            [
                'name' => 'Haas F1 Team',
                'championships' => '0',
                'team_principal' => 'Guenther Steiner',
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
