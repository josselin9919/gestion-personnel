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
        Schema::create('experiences_enquetes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_temporaire_id')->constrained('personnels_temporaires')->onDelete('cascade');
            $table->enum('type_enquete', ['menage', 'entreprise', 'socio_economique']);
            $table->year('annee');
            $table->string('intitule');
            $table->string('fonction');
            $table->string('structure');
            $table->integer('nombre_enquetes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences_enquetes');
    }
};
