<?php

namespace App\Http\Controllers;

use App\Models\Execution;
use App\Models\Training;
use App\Models\Workout;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function show(Request $request)
    {
        $training = $request->user()->trainings;
        $training->load('executions');
        return $training;
    }

    public function start(Request $request, Workout $workout)
    {
        $user = $request->user();
        $training = new Training();
        $training->workout()->associate($workout);
        $training->user()->associate($user);
        $training->save();

        foreach ($workout->exercises as $exercise) {
            $execution = new Execution();

            $execution->exercise()->associate($exercise);
            $execution->training()->associate($training);
            $execution->user()->associate($request->user());

            $execution->save();
        }

        $training->load('executions');

        return $training;
    }

    public function complete(Request $request, Workout $workout, Training $training)
    {
        $training->update([
            'is_completed' => true
        ]);
        $training->load('executions');
        return $training;
    }
}
