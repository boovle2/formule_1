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
            ['Fname' => 'Max', 'Lname' => 'Verstappen', 'team_id' => 1,'number' => 1, 'points' => 0, 'image' => 'drivers/2025redbullracingmaxver01right.avif'],
            ['Fname' => 'Yuki', 'Lname' => 'Tsunoda', 'team_id' => 1,'number' => 22, 'points' => 0, 'image' => 'drivers/2025redbullracingyuktsu01right.avif'],
            ['Fname' => 'Charles', 'Lname' => 'Leclerc', 'team_id' => 2,'number' => 16, 'points' => 0, 'image' => 'drivers/2025ferrarichalec01right.avif'],
            ['Fname' => 'Lewis', 'Lname' => 'Hamilton', 'team_id' => 2,'number' => 44, 'points' => 0, 'image' => 'drivers/2025ferrarilewham01right.avif'],
            ['Fname' => 'Lando', 'Lname' => 'Norris', 'team_id' => 3,'number' => 4, 'points' => 0, 'image' => 'drivers/dpX0GvUNxfoRt48gVO3rhbqeuaK8CtUxtK3eiG8A.avif'],
            ['Fname' => 'Oscar', 'Lname' => 'Piastri', 'team_id' => 3,'number' => 81, 'points' => 0, 'image' => 'drivers/I5263OK9x5JCgzYNCNz7n51QsrT5iUsOcHrxkM3k.avif'],
            ['Fname' => 'George', 'Lname' => 'Russell', 'team_id' => 4,'number' => 63, 'points' => 0, 'image' => 'drivers/2025mercedesgeorus01right.avif'],
            ['Fname' => 'Kimi', 'Lname' => 'Antonelli', 'team_id' => 4,'number' => 5, 'points' => 0, 'image' => 'drivers/2025mercedesandant01right.avif'],
            ['Fname' => 'Fernando', 'Lname' => 'Alonso', 'team_id' => 5,'number' => 14, 'points' => 0, 'image' => 'drivers/2025alpinefracol01right.avif'],
            ['Fname' => 'Lance', 'Lname' => 'Stroll', 'team_id' => 5,'number' => 18, 'points' => 0, 'image' => 'drivers/2025alpinepiegas01right.avif'],
            ['Fname' => 'Pierre', 'Lname' => 'Gasly', 'team_id' => 6,'number' => 10, 'points' => 0, 'image' => 'drivers/2025haasf1teamestoco01right.avif'],
            ['Fname' => 'Jack', 'Lname' => 'Doohan', 'team_id' => 6,'number' => 27, 'points' => 0, 'image' => 'drivers/2025kicksaubergabbor01right.avif'],
            ['Fname' => 'Esteban', 'Lname' => 'Ocon', 'team_id' => 7,'number' => 31, 'points' => 0, 'image' => 'drivers/2025astonmartinferalo01right.avif'],
            ['Fname' => 'Oliver', 'Lname' => 'Bearman', 'team_id' => 7,'number' => 21, 'points' => 0, 'image' => 'drivers/2025astonmartinlanstr01right.avif'],
            ['Fname' => 'Liam', 'Lname' => 'Lawson', 'team_id' => 8,'number' => 4, 'points' => 0, 'image' => 'drivers/2025williamsalealb01right.avif'],
            ['Fname' => 'Isack', 'Lname' => 'Hadjar', 'team_id' => 8,'number' => 5, 'points' => 0, 'image' => 'drivers/2025williamscarsai01right.avif'],
            ['Fname' => 'Alex', 'Lname' => 'Albon', 'team_id' => 9,'number' => 23, 'points' => 0, 'image' => 'drivers/2025williamsalealb01right.avif'],
            ['Fname' => 'Carlos', 'Lname' => 'Sainz', 'team_id' => 9,'number' => 55, 'points' => 0, 'image' => 'drivers/2025williamscarsai01right.avif'],
            ['Fname' => 'Nico', 'Lname' => 'Hülkenberg', 'team_id' => 10,'number' => 27, 'points' => 0, 'image' => 'drivers/2025haasf1teamestoco01right.avif'],
            ['Fname' => 'Gabriel', 'Lname' => 'Bortoleto', 'team_id' => 10,'number' => 88, 'points' => 0, 'image' => 'drivers/2025kicksaubergabbor01right.avif'],
        ];

        foreach ($drivers as $driver) {
            DB::table('drivers')->insert($driver);
        }
    }
}
