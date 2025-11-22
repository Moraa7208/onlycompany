<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'start_time',
        'end_time',
        'destination',
        'purpose',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now());
    }

    public function scopeOverlapping($query, $startTime, $endTime)
    {
        return $query->where(function ($q) use ($startTime, $endTime) {
            $q->whereBetween('start_time', [$startTime, $endTime])
              ->orWhereBetween('end_time', [$startTime, $endTime])
              ->orWhere(function ($q) use ($startTime, $endTime) {
                  $q->where('start_time', '<=', $startTime)
                    ->where('end_time', '>=', $endTime);
              });
        });
    }
}
