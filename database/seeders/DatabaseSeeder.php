<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PositionSeeder::class,
            ComfortCategorySeeder::class,
            DriverSeeder::class,
            CarSeeder::class,
            UserSeeder::class,
            PositionComfortCategorySeeder::class,
            BookingSeeder::class,
        ]);
    }
}
