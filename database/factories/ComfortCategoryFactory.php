<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ComfortCategory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ComfortCategory>
 */
class ComfortCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ComfortCategory::class;
    public function definition(): array
    {
        return [
        'name' => fake()->randomElement(['Первая', 'Вторая', 'Третья']),
        ];
    }
}
