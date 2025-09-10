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
        // Create a specific Admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password', // Factory will hash it
            'role' => 'admin',
        ]);

        // Create a generic test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'fixed_entry',
        ]);

        // Create other user types
        User::factory()->create([
            'name' => 'Approver User',
            'email' => 'approver@example.com',
            'role' => 'approver',
        ]);

        User::factory()->create([
            'name' => 'Variable User',
            'email' => 'variable@example.com',
            'role' => 'variable_entry',
        ]);
    }
}
