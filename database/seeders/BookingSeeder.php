<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $users = User::all();
        $cars = Car::all();

        // Create some upcoming confirmed bookings
        foreach ($cars->take(5) as $car) {
            Booking::factory()
                ->count(2)
                ->upcoming()
                ->create([
                    'car_id' => $car->id,
                    'user_id' => $users->random()->id,
                ]);
        }

        // Create random bookings
        Booking::factory()->count(20)->create();
    }
}
