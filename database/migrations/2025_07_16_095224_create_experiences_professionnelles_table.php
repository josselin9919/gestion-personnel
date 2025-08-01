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
        Schema::create('experiences_professionnelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_temporaire_id')->constrained('personnels_temporaires')->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->string('pays');
            $table->foreignId('structure_id')->constrained('structures');
            $table->string('poste');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences_professionnelles');
    }
};
