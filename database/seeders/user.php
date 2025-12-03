<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class user extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = [
            'name' => 'Bart van Baarle',
            'email' => 'BartvanBaarle@gmail.com',
            'password' => bcrypt('Bart1234'),
            'role' => 'admin',
        ];

        DB::table('users')->insert($adminUser);
    }
}