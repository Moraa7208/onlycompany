<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Car;
use App\Models\ComfortCategory;
use App\Models\Driver;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Car::class;
    public function definition(): array
    {
        $brands = ['Toyota', 'Mercedes', 'BMW', 'Audi', 'Lexus', 'Volkswagen'];
        $models = [
            'Toyota' => ['Camry', 'Corolla', 'Land Cruiser'],
            'Mercedes' => ['E-Class', 'S-Class', 'C-Class'],
            'BMW' => ['3 Series', '5 Series', '7 Series'],
            'Audi' => ['A4', 'A6', 'A8'],
            'Lexus' => ['ES', 'LS', 'RX'],
            'Volkswagen' => ['Passat', 'Tiguan', 'Touareg'],
        ];

        $brand = fake()->randomElement($brands);
        $model = fake()->randomElement($models[$brand]);

        return [
            'name' => "$brand $model",
            'model' => $model,
            'comfort_category_id' => ComfortCategory::inRandomOrder()->first()->id,
            'driver_id' => Driver::factory(),
        ];
    }
}
