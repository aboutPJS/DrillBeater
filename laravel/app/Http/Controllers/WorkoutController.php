<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkoutController extends Controller
{
    public function show(Request $request)
    {
        return $request->user()->workouts;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $workout = $request->user()->workouts()->create($request->only([
            'name',
        ]));

        return $workout;
    }

    public function add(Request $request, Workout $workout, Exercise $exercise)
    {

        Log::info($workout);
        Log::info($exercise);
        Log::info($exercise->id);


        $workout->exercises()->attach($exercise->id);


        return $workout;
    }


}
