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
        $workouts = $request->user()->workouts;
        $workouts->load('exercises');
        return $workouts;
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
        $exercises = $workout->exercises();
        $isFromUser = $exercise->user->id === $request->user()->id;
        $isNotInList = !$exercises->get()->contains($exercise);

        if ($isNotInList && $isFromUser) {
            $exercises->attach($exercise->id);
        }

        $workout->load('exercises');
        return $workout;
    }

    public function remove(Request $request, Workout $workout, Exercise $exercise)
    {
        $workout->exercises()->detach($exercise->id);
        $workout->load('exercises');
        return $workout;
    }
}
