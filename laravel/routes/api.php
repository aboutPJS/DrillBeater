<?php

use App\Http\Controllers\ExecutionController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TrainingController;
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


//Route::post('/login', [LoginController::class, 'submit']);
//Route::post('/login/verify', [LoginController::class, 'verify']);

Route::post('/login', [LoginController::class, 'createUser']);
Route::post('/login/verify', [LoginController::class, 'verifyUser']);


//create workout
Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/workout', [WorkoutController::class, 'create']);
    Route::post('/workout/{workout}/exercise/{exercise}', [WorkoutController::class, 'add']);
    Route::delete('/workout/{workout}/exercise/{exercise}', [WorkoutController::class, 'remove']);
    Route::get('/workout', [WorkoutController::class, 'show']);
    Route::get('/workout/{workout}', [WorkoutController::class, 'showSingle']);

    Route::post('/exercise', [ExerciseController::class, 'create']);
    Route::get('/exercise', [ExerciseController::class, 'show']);

    Route::get('/training', [TrainingController::class, 'show']);
    Route::post('/training/workout/{workout}/', [TrainingController::class, 'start']);
    Route::put('/training/{training}', [TrainingController::class, 'complete']);
    Route::get('/training/{training}', [TrainingController::class, 'showSingle']);

    Route::put('/training/{training}/execution/{execution}', [ExecutionController::class, 'update']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});





