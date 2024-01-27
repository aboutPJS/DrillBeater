<?php

use App\Models\Exercise;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('executions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Exercise::class);
            $table->foreignIdFor(Training::class);
            $table->foreignIdFor(User::class);
            $table->string('notes')->nullable();
            $table->integer('reps')->nullable();
            $table->integer('sets')->nullable();
            $table->boolean('is_completed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executions');
    }
};
