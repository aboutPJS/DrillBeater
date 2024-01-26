<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exercise_workout', function (Blueprint $table) {
            $table->id();

            $table->unsignedBiginteger('exercise_id')->unsigned();
            $table->unsignedBiginteger('workout_id')->unsigned();

            $table->foreign('exercise_id')->references('id')
                ->on('exercises')->onDelete('cascade');
            $table->foreign('workout_id')->references('id')
                ->on('workouts')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_workout');
    }
};
