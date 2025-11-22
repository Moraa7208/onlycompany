<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Booking::class;
    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('now', '+30 days');
        $endTime = (clone $startTime)->modify('+' . fake()->numberBetween(2, 8) . ' hours');

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'car_id' => Car::inRandomOrder()->first()->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'destination' => fake()->city(),
            'purpose' => fake()->sentence(),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }


    public function upcoming(): static
    {
        $startTime = fake()->dateTimeBetween('+1 day', '+30 days');
        $endTime = (clone $startTime)->modify('+' . fake()->numberBetween(2, 8) . ' hours');

        return $this->state(fn (array $attributes) => [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'confirmed',
        ]);
    }
}
