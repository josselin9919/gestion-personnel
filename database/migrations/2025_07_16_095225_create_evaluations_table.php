<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_temporaire_id')->constrained('personnels_temporaires')->onDelete('cascade');
            $table->string('evaluateur_nom');
            $table->string('mission_contexte');
            $table->text('commentaire_global')->nullable();
            $table->decimal('score_total', 4, 2)->nullable(); // calculé automatiquement
            $table->date('date_evaluation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
