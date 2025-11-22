<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ComfortCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relationships
    public function positions()
    {
        return $this->belongsToMany(
            Position::class,
            'position_comfort_category'
        );
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
