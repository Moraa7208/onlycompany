<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = Position::all();

        // Create test users for each position
        foreach ($positions as $position) {
            User::factory()->count(2)->create([
                'position_id' => $position->id,
            ]);
        }

        // Create a specific test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'position_id' => Position::where('name', 'Manager')->first()->id,
        ]);
    }
}
