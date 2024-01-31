<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function show(Request $request)
    {
        $workouts = $request->user()->workouts;
        $workouts->load('exercises');
        return $workouts;
    }

    public function showSingle(Request $request, Workout $workout): Workout|JsonResponse
    {
        if ($request->user()->id !== $workout->user->id) {
            return response()->json(['message' => 'Not your workout'], 401);
        }

        $workout->load('exercises');

        return $workout;
    }

    public function create(Request $request): Workout|JsonResponse
    {
        $request->validate([
            'name' => 'required|min:8',
        ]);

        $nameTaken = Workout::where('user_id', $request->user()->id)
            ->where('name', $request->name)
            ->exists();

        if ($nameTaken) {
            return response()->json(['message' => 'Choose a different name'], 401);
        }

        $workout = $request->user()->workouts()->create($request->only([
            'name',
            'description'
        ]));

        return $workout;
    }

    public function add(Request $request, Workout $workout, Exercise $exercise): Workout
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

    public function remove(Request $request, Workout $workout, Exercise $exercise): Workout
    {
        $isFromUser = $exercise->user->id === $request->user()->id;
        if ($isFromUser) {
            $workout->exercises()->detach($exercise->id);
        }

        $workout->load('exercises');
        return $workout;
    }
}
