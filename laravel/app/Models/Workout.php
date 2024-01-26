<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercises(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, 'exercise_workout', 'workout_id', 'exercise_id');
    }

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }
}
