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

        DB::table('users')->updateOrInsert(
            ['email' => 'administrator@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 'administrator',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        $this->call([
            JalurSeeder::class,
        ]);
    }
}
