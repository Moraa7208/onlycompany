<?php

use App\Http\Controllers\Api\AvailableCarController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/available-cars', [AvailableCarController::class, 'index']);
});