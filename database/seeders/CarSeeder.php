<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\ComfortCategory;
class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ComfortCategory::all();

        // Create cars for each category
        foreach ($categories as $category) {
            Car::factory()->count(3)->create([
                'comfort_category_id' => $category->id,
            ]);
        }
    }
}
