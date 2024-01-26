<?php

namespace App\Http\Controllers;

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
}
