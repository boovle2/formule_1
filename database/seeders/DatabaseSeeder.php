<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RaceSeeder;
use Database\Seeders\SprintRaceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RaceSeeder::class,
            SprintRaceSeeder::class,
            TeamsSeed::class,
            DriversSeed::class,
            user::class,
        ]);
    }
}
