<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('challenge_id')->constrained()->cascadeOnDelete();
            $table->integer('points_awarded')->default(0);
            $table->timestamp('solved_at')->nullable();
            $table->timestamps();

            $table->unique(['team_id', 'challenge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solves');
    }
};