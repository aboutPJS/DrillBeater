<?php

namespace App\Http\Controllers;

use App\Models\Execution;
use App\Models\Training;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrainingController extends Controller
{
    public function show(Request $request)
    {
        $trainings = $request->user()->trainings;
        $trainings->load('executions');
        $trainings->load('workout');

        return $trainings;
    }

    public function showSingle(Request $request, Training $training)
    {
        if (!$this->isFromUser($request, $training)) {
            return response()->json(['message' => 'Training not found'], 404);
        }

        $training->load('executions');
        $training->load('workout');
        $training->workout->load('exercises');
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
        if (!$this->isFromUser($request, $training)) {
            return response()->json(['message' => 'Training not found'], 404);
        }

        $training->update([
            'is_completed' => true
        ]);
        $training->load('executions');
        return $training;
    }


    private function isFromUser(Request $request, Training $training)
    {
        return $training->user->id === $request->user()->id;
    }
}
