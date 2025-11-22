<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;
class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'CEO'],
            ['name' => 'Director'],
            ['name' => 'Manager'],
            ['name' => 'Senior Specialist'],
            ['name' => 'Specialist'],
            ['name' => 'Junior Specialist'],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
