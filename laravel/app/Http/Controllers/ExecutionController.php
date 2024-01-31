<?php

namespace App\Http\Controllers;

use App\Models\Execution;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExecutionController extends Controller
{
    public function update(Request $request, Training $training, Execution $execution)
    {
        $request->validate([
            'reps' => 'required|numeric',
            'sets' => 'required|numeric',
            'weight' => 'required|numeric',
            'is_completed' => 'required|boolean',
        ]);

        $exercise = $execution->exercise;



        if ($request->reps > $exercise->reps_max) {
            return response()->json(['error' => 'Reps should not exceed maximum of exercise', $exercise->reps_max], 400);
        }
        if ($request->reps < $exercise->reps_min) {
            return response()->json(['error' => 'Reps must be higher than minimum of exercise',$exercise->min], 400);
        }
        if ($request->sets > $exercise->sets_max) {
            return response()->json(['error' => 'Sets should not exceed maximum of exercise', $exercise->sets_max], 400);
        }
        if ($request->sets < $exercise->sets_min) {
            return response()->json(['error' => 'Sets must be higher than minimum of exercise', $exercise->sets_min], 400);
        }

        $execution->update([
            'reps' => $request->get('reps'),
            'sets' => $request->get('sets'),
            'weight' => $request->get('weight'),
            'is_completed' => $request->get('is_completed'),
            'notes' => $request->get('notes'),
        ]);

        return $execution;
    }
}
