<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class AvailableCarController extends Controller
{
/**
     * Get available cars for the authenticated user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'model' => 'nullable|string',
            'comfort_category_id' => 'nullable|exists:comfort_categories,id',
        ]);

        $user = Auth::user();
        
        // Get user's allowed comfort categories
        $allowedCategoryIds = $user->position
            ->comfortCategories()
            ->pluck('comfort_categories.id');

        // If no allowed categories, return empty
        if ($allowedCategoryIds->isEmpty()) {
            return response()->json([
                'message' => 'No cars available for your position',
                'data' => []
            ]);
        }

        // Build query for cars
        $carsQuery = Car::with(['comfortCategory', 'driver'])
            ->whereIn('comfort_category_id', $allowedCategoryIds);

        // Apply filters
        if ($request->filled('model')) {
            $carsQuery->where('model', 'like', '%' . $request->model . '%');
        }

        if ($request->filled('comfort_category_id')) {
            // Check if user has access to this category
            if (!$allowedCategoryIds->contains($request->comfort_category_id)) {
                return response()->json([
                    'message' => 'You do not have access to this comfort category',
                ], 403);
            }
            
            $carsQuery->where('comfort_category_id', $request->comfort_category_id);
        }

        // Get all potential cars
        $cars = $carsQuery->get();

        // Filter by availability (check for booking conflicts)
        $availableCars = $cars->filter(function ($car) use ($validated) {
            return $this->isCarAvailable(
                $car, 
                $validated['start_time'], 
                $validated['end_time']
            );
        });

        return response()->json([
            'message' => 'Available cars retrieved successfully',
            'data' => $availableCars->values()->map(function ($car) {
                return [
                    'id' => $car->id,
                    'name' => $car->name,
                    'model' => $car->model,
                    'comfort_category' => [
                        'id' => $car->comfortCategory->id,
                        'name' => $car->comfortCategory->name,
                    ],
                    'driver' => [
                        'id' => $car->driver->id,
                        'name' => $car->driver->name,
                    ],
                ];
            }),
            'total' => $availableCars->count(),
        ]);
    }

    /**
     * Check if car is available for the given time period
     * 
     * @param Car $car
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
    private function isCarAvailable(Car $car, string $startTime, string $endTime): bool
    {
        // Check for overlapping bookings
        $hasConflict = $car->bookings()
            ->active() // Only check active bookings (pending/confirmed)
            ->overlapping($startTime, $endTime)
            ->exists();

        return !$hasConflict;
    }
}
