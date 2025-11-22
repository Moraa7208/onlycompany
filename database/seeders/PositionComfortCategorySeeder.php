<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\ComfortCategory;
class PositionComfortCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = Position::all();
        $categories = ComfortCategory::all();

        // CEO - all categories
        $positions->where('name', 'CEO')->first()
            ->comfortCategories()->attach($categories->pluck('id'));

        // Director - first and second
        $positions->where('name', 'Director')->first()
            ->comfortCategories()->attach(
                $categories->whereIn('name', ['Первая', 'Вторая'])->pluck('id')
            );

        // Manager - second and third
        $positions->where('name', 'Manager')->first()
            ->comfortCategories()->attach(
                $categories->whereIn('name', ['Вторая', 'Третья'])->pluck('id')
            );

        // Senior Specialist - second and third
        $positions->where('name', 'Senior Specialist')->first()
            ->comfortCategories()->attach(
                $categories->whereIn('name', ['Вторая', 'Третья'])->pluck('id')
            );

        // Specialist - only third
        $positions->where('name', 'Specialist')->first()
            ->comfortCategories()->attach(
                $categories->where('name', 'Третья')->pluck('id')
            );

        // Junior Specialist - only third
        $positions->where('name', 'Junior Specialist')->first()
            ->comfortCategories()->attach(
                $categories->where('name', 'Третья')->pluck('id')
            );
    }
}
