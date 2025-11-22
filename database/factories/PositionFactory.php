<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Position;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Position::class;
    public function definition(): array
    {
        return [
        'name' => fake()->randomElement([
                'CEO',
                'Director',
                'Manager',
                'Senior Specialist',
                'Specialist',
                'Junior Specialist',
            ]),
        ];
    }
}
