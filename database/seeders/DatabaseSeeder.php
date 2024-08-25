<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Rob Thomas',
            'email' => 'rob.thomas@empuls3.com',
            'password' => bcrypt('G00dBoySpot!!1013'),
        ]);
    }
}
