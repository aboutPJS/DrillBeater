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
            'is_completed' => 'required|boolean',
        ]);

        $execution->update([
            'reps' => $request->get('reps'),
            'sets' => $request->get('sets'),
            'is_completed' => $request->get('is_completed'),
            'notes' => $request->get('notes'),
        ]);

        Log::info('update');

        return $execution;
    }
}
