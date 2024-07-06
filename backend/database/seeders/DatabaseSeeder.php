<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(30)->create();
        // \App\Models\Election::factory(1)->create();
        // \App\Models\Candidate::factory(6)->create(); 
        // \App\Models\User::factory()->create([
            // \App\Models\Vote::factory(20)->create();
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
