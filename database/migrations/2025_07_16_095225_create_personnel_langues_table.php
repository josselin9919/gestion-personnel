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
        Schema::create('personnel_langues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_temporaire_id')->constrained('personnels_temporaires')->onDelete('cascade');
            $table->foreignId('langue_id')->constrained('langues')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['personnel_temporaire_id', 'langue_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel_langues');
    }
};
