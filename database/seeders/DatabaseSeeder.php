<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'administrator@gmail.com',
                'password' => bcrypt('password'),
                'telepon'  => '08123456789',
                'role' => 'administrator'
            ],
            [
                'name' => 'Operator',
                'email' => 'operator@gmail.com',
                'password' => bcrypt('password'),
                'telepon'  => '08123456789',
                'role' => 'operator'
            ]
        ]);
    }
}
