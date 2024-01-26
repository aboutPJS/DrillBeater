<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/login', [LoginController::class, 'submit']);
Route::post('/login/verify', [LoginController::class, 'verify']);


//create workout
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/workout', [WorkoutController::class, 'create']);
    Route::post('/workout/{workout}/exercise/{exercise}', [WorkoutController::class, 'add']);
    Route::get('/workout', [WorkoutController::class, 'show']);

    Route::post('/exercise', [ExerciseController::class, 'create']);
    Route::get('/exercise', [ExerciseController::class, 'show']);

    //get workouts

//create exercise

//create execution

//create Training

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});





