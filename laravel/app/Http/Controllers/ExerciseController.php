<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{

    public function show(Request $request)
    {
        return Exercise::where('user_id', $request->user()->id)->get();
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'reps_min' => 'required|numeric',
            'reps_max' => 'required|numeric',
            'sets_min' => 'required|numeric',
            'sets_max' => 'required|numeric',
        ]);

        $exercise = new Exercise();

        $exercise->name = $request->get('name');
        $exercise->description = $request->get('description', null);
        $exercise->reps_min = $request->get('reps_min');
        $exercise->reps_max = $request->get('reps_max');
        $exercise->sets_min = $request->get('sets_min');
        $exercise->sets_max = $request->get('sets_max');
        $exercise->user_id = $request->user()->id;

        $exercise->save();

        return $exercise;
    }
}
